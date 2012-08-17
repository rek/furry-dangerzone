<?php

namespace Collective\GovtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Collective\GovtBundle\Entity\Link;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkController extends Controller
{

    /**
    * Show the links for a location
    */ 
    public function showAction($location_id)
    {
       $links = $this->getDoctrine()
         ->getRepository('CollectiveGovtBundle:Link')
         ->findByLocationId($location_id);

       if (!$links) {
         throw $this->createNotFoundException('No links found for this location: ' . $location_id);
       }

       return $this->render('CollectiveGovtBundle:Link:show.html.twig', array('links' => $links));
    }

    /**
    * Show create new location page
    *
    */
    public function newAction(Request $request)
    {
       $location = $this->getDoctrine()
                          ->getEntityManager()
                          ->getRepository('CollectiveGovtBundle:Location')
                          ->find($request->get('id'));
    	 
       return $this->render('CollectiveGovtBundle:Link:new.html.twig', array('location' => $location));
    }     

    /**
    * Add a link
    */ 
    public function addAction(Request $request)
    {
       $id = $request->get('id');

       $location = $this->getDoctrine()
         ->getRepository('CollectiveGovtBundle:Location')
         ->find($id);

       if (!$location) {
         throw $this->createNotFoundException('Invalid location: ' . $id);
       }
      
       $link = new Link();
       $link->setLocation($location);
       $link->setLink($request->get('link'));
       $link->setTitle($request->get('title'));
   
       $em = $this->getDoctrine()->getEntityManager();
       $em->persist($link);
       $em->flush();
       
       if($request->isXmlHttpRequest())
         return new Response('Added');

       $this->get('session')->setFlash('notice', 'Link '.$link->getId().' added successfully.');
       return $this->redirect($this->generateUrl('CollectiveGovtBundle_show_location', array('id'=> $id)));       
    }
    
    /**
    * Remove a link
    */ 
    public function removeAction(Request $request)
    {
    	 // get our link
    	 $id = $request->get('id');
       $em = $this->getDoctrine()->getEntityManager();
       $link = $em->getRepository('CollectiveGovtBundle:Link')->find($id);

       if (!$link) {
         throw $this->createNotFoundException('Link not found with id: ' . $id);
       }
       
       // save the id, so we know where to go back to.
       $location = $link->getLocation()->getId();
       
       // remove it
       $em->remove($link);
       $em->flush();  
       
       // if this flag is set, then just return text (used for ajax calls)
       if($request->isXmlHttpRequest())
         return new Response('Added');

       // show a nice message and return to the link list page
       $this->get('session')->setFlash('notice', 'Link '.$id.' removed successfully.');
       return $this->redirect($this->generateUrl('CollectiveGovtBundle_show_location', array('id'=> $location)));       
    }
   
}