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
use AppBundle\Entity\Students;
use AppBundle\Form\StudentsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Forms;

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
            $me    = $repository->find($request->get('id') );
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
    * @Method("PUT")
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
        $repository = $this->getDoctrine()->getRepository("AppBundle:Students"); 
        $student    = $repository->find($request->get('id'));
        
        if($student->getUser_id() != $user->getId()){
            throw new AccessDeniedException('This user does not have access to this section.');      
        } 
        $form = $this->createForm(StudentsType::class  , $student);
        $form->submit($request->request->all());
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($student);
            $em->flush();
        }        

        $result = array('status' => true , 'data' => $student);
        $serializer = $this->container->get('jms_serializer');       
        $data   = $serializer->serialize($result, 'json');
        return new Response($data);  
    }
}