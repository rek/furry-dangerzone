<?php

namespace Collective\GovtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Collective\GovtBundle\Entity\Location;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LocationController extends Controller
{
           
    /**
     * Display all locations
     *
     * @Route("/{_format}", name="CollectiveGovtBundle_homepage")
     * @Template()
     */
    public function indexAction()
    {
       $locations = $this->getDoctrine()
        ->getRepository('CollectiveGovtBundle:Location')
        ->findAll();

       if (!$locations) {
         throw $this->createNotFoundException('No locations found.. yet');
       }
       return array('data' => $locations);
       
       // perhaps more easy
       $format = $this->getRequest()->getRequestFormat();
       return $this->render('CollectiveGovtBundle:Location:'.$format.'.html.twig', array('data' => $locations));
    }

    /**
    * Show create new location page
    *
    */
    public function newAction()
    {
       return $this->render('CollectiveGovtBundle:Location:new.html.twig');
    }       
   
    /**
    * Add new location
    *
    */           
    public function addAction(Request $request)
    {
       // prepare a response
       $response = new Response();

       // require login
       if (!$this->get('security.context')->isGranted('ROLE_USER'))
       {
         $response->setContent('Not Authorized');
         $response->setStatusCode('403');                                                
         return $response;
       }
       
       $location = new Location();
       $location->setName($request->get('name'));
       $location->setLat($request->get('lat'));
       $location->setLon($request->get('lon'));
   
       $em = $this->getDoctrine()->getEntityManager();
       $em->persist($location);
       $em->flush();
       
       // if it is an ajax request, return the new id only.
       if($request->isXmlHttpRequest())
       {
         $response->setContent($location->getId());                                                
         return $response;
       }

       // else if we are accessing from the web, display a nice message
       $this->get('session')->setFlash('notice', 'Location '.$location->getId().' added successfully.');
       return $this->redirect($this->generateUrl('CollectiveGovtBundle_homepage'));       
    }

    /**
     * Show one location
     * 
     * @Route("/location/{id}.{_format}", name="CollectiveGovtBundle_show_location")
     * @Template()
     */
    public function showAction($id)
    {
       $location = $this->getDoctrine()
                          ->getEntityManager()
                          ->getRepository('CollectiveGovtBundle:Location')
                          ->find($id);

       if(!$location)
       {
         throw $this->createNotFoundException('Location not found with id: ' . $id);
       }

       return array('location' => $location);
    }
    
    /**
    * Remove a location
    *
    */
    public function removeAction(Request $request)
    {
       // prepare a response
       $response = new Response();

       // require login
       if (!$this->get('security.context')->isGranted('ROLE_USER'))
       {
         $response->setContent('Not Authorized');
         $response->setStatusCode('403');                                                
         return $response;
       }
      
    	 // get our link
    	 $id = $request->get('id');
       $em = $this->getDoctrine()->getEntityManager();
       $location = $em->getRepository('CollectiveGovtBundle:Location')->find($id);

       if (!$location) {
         throw $this->createNotFoundException('Location not found with id: ' . $id);
       }

       $em->remove($location);
       $em->flush();  
       
       // if it is an ajax request, return the state.
       if($request->isXmlHttpRequest())
       {
         $response->setContent($id);                                                
         return $response;
       }

       // else if we are accessing from the web, display a nice message     
       $this->get('session')->setFlash('notice', 'Location '.$id.' removed successfully.');
       return $this->redirect($this->generateUrl('CollectiveGovtBundle_homepage'));       
    }
    
    
}