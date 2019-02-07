<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $apiList = [
            'GetUserList' => 'GET\http://127.0.0.1/users',
            'AddUser' => 'POST\http://127.0.0.1/users',
            'EditUser' => 'PUT\http://127.0.0.1/users',
        ];

        return new Response(json_encode($apiList));
    }

    /**
     * @Route("/users", name="getAllUsers")
     *
     * @param Request $request
     * @return mixed
     */
    public function getUsers(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $res = $conn->fetchAll('SELECT * FROM users');

        return new Response(json_encode($res));
    }

    /**
     * @Route("/users", methods={"POST"}, name="addUser")
     *
     * @param Request $request
     * @return mixed
     */
    public function addUser(Request $request)
    {
        $data = json_decode($request->getContent());

        $user = new Users();

        $user->setFirstname($data->firstName);
        $user->setLastname($data->lastName);
        $user->setDepartment($data->department);
        $user->setPhonenumber($data->phoneNumber);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

//    /**
//     * @Route("/", name="homepage")
//     */
//    public function indexAction(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//        ]);
//    }
//
//    /**
//     * @Route("/", name="homepage")
//     */
//    public function indexAction(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//        ]);
//    }
}
