<?php

namespace Collective\GovtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * _@Route("/secure")
 */
class SecurityController extends Controller
{
    /**
     * _@Route("/login", name="_login")
     * @Template()
     */
    public function loginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * _@Route("/login_check", name="_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * _@Route("/logout", name="_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    public function getAuthStateAction()
    {
      $return = array( 'responseCode' => 200, 
                        'state'        => $this->get('security.context')->isGranted('ROLE_USER')
                      );
     
     //make sure it has the correct content type
     return new Response(json_encode($return), 200, array('Content-Type'=>'application/json'));
   }    
}