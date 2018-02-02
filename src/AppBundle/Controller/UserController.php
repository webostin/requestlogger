<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Message;
use AppBundle\Form\Message\MessageCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package AppBundle\Controller
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/view")
     */
    public function viewAction()
    {
        return $this->render('AppBundle::user/view.html.twig');
    }

    /**
     * @Route("/create", name="user_create")
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $message = new Message();
        $message->setUser($user->getUsername());
        $form = $this->createForm(MessageCreateType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('user_create');
        }

        return $this->render(
            'AppBundle::user/create.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }
}