<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializerBundle;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MeController extends Controller
{  
     /**
    * RESTFul action which returns the data of students   
    * @Route("api/me.json/{id}")
    * @Method("GET")
    * @ApiDoc(
    *  resource = "true",
    *  description = "Data for Student" ,
    *  output = "\AppBundle\Entity\Students",
    *  statusCodes = {
    *      200 = "Returned when successful" ,
    *      400 = "Returned when the page is not found"   
    *  }
    * )
    *      
    * @return Response{'status and data'}
    */
    public function getMe(Request $request){
        $user = $this->getUser();
        if($request->get('id') != $user->getId()){
            throw new AccessDeniedException('This user does not have access to this section.');      
        }
        $repository = $this->getDoctrine()->getRepository("AppBundle:Students"); 
        try{
            $me    = $repository->findBy(array('id'   => $request->get('id') ));
        }catch(\Exception $exception){
            $me = NULL;
        }
        $result = array('status' => true , 'data' => $me);
        $serializer = $this->container->get('jms_serializer');       
        $data   = $serializer->serialize($result, 'json');
        return new Response($data);  
    }

         /**
    * RESTFul action for update data student  
    * @Route("api/me.json/{id}")
    * @Method("POST")
    * @ApiDoc(
    *  resource = "true",
    *  description = "Update data students " ,
    *  output = "\AppBundle\Entity\Students",
    *  statusCodes = {
    *      200 = "Returned when successful" ,
    *      400 = "Returned when the page is not found"  
    *  }
    * )
    *      
    * @return Response{'status and data'}
    */
    public function updateMe(Request $request){
        $user = $this->getUser();
        if($request->get('id') != $user->getId()){
            throw new AccessDeniedException('This user does not have access to this section.');      
        }
        $repository = $this->getDoctrine()->getRepository("AppBundle:Students"); 
        try{
            $me    = $repository->findBy(array('id'   => $request->get('id') ));
        }catch(\Exception $exception){
            $me = NULL;
        }
        $result = array('status' => true , 'data' => $me);
        $serializer = $this->container->get('jms_serializer');       
        $data   = $serializer->serialize($result, 'json');
        return new Response($data);  
    }
}
