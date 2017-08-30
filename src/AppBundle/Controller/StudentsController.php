<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializerBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class StudentsController extends FOSRestController
{
    /**
     * RESTFul action which returns all students   
     * @Route("api/students.json")
     * @Method("GET")
     * @ApiDoc(
     *  resource = "true",
     *  description = "Gets all Students" ,
     *  output = "\AppBundle\Entity\User",
     *  statusCodes = {
     *      200 = "Returned when successful" ,
     *      400 = "Returned when the page is not found"
     *  }
     * )
     *      
     * @return Response{'status and data'}
     */
    public function getStudents(){         
        $repository = $this->getDoctrine()->getRepository("AppBundle:Students"); 
        try{
            $students   = $repository->findAll();         
        }catch(\Exception $e){

            return new Response($e->getMessage);
        }  
        $result = array('status' => true , 'data' => $students);
        $serializer = $this->container->get('jms_serializer');       
        $data   = $serializer->serialize($result, 'json');
        return new Response($data);  
   
    } 

    /**
     * RESTFul action which returns all students 
     * @Route("/api/students.json/{id}")
     * @Method("GET")
     * 
     * @ApiDoc(
     *  resource = true,
     *  description = "Gets all Students" ,
     *  output = "\AppBundle\Entity\User",
     *  statusCodes = {
     *      200 = "Returned when successful" ,
     *      400 = "Returned when the page is not found"
     *  }
     * )
     * @param  Request
     * @return Response{'status and data'} 
     */
    public function getStudent(Request $request){
        $repository = $this->getDoctrine()->getRepository("AppBundle:Students");      
        try{
            $student    = $repository->findBy(array('id'   => $request->get('id') ));
        }catch(\Exception $exception){
            $student = NULL;
        } 
        $result = array('status' => true , 'data' => $student);        
        $serializer = $this->container->get('jms_serializer');       
        $data   = $serializer->serialize($result, 'json');
        return new Response($data);
    }

    /**
     * RESTFul action which delete Student by id
     * @Route("/api/students.json/{id}")
     * @Method("DELETE")
     * 
     * @ApiDoc(
     *  resource = true ,
     *  description = "Delete a Student for a given Id" ,
     *  statusCodes = {
     *     204 = "Returned when successful",
     *     401 = "Returned when not authenticated",
     *     403 = "Returned when not having permissions",
     *     404 = "Returned when the type is not found"
     *  }
     * 
     * )
     * @param Request $request
     * @param $id
     * @return Response{'status and data'}
     */
    public function deleteStudent($id){
        $repository = $this->getDoctrine()->getManager();
        $repository = $repository->getRepository('AppBundle:Students');
        $student    = $repository->findOneBy(array('id'=>$id ));   
        if(!$student){
            $data       = array('status' => false , "message" => "Student not exist");
            $serializer = $this->container->get('jms_serializer');       
            $result     = $serializer->serialize($data, 'json');
            return new Response($result);
        }
        try{              
            $repository->remove($student);
            $repository->flush();
        }catch(\Exception $e){                
             return new Response($e->getMessage());
        }
        $data       = array('status' => true , "message" => "Deleted");
        $serializer = $this->container->get('serializer');       
        $result     = $serializer->serialize($data, 'json');
        return new Response($result);

    }

   
}
