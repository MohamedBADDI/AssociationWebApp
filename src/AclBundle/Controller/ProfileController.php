<?php
/**
 * Created by PhpStorm.
 * User: achouri
 * Date: 30/04/2017
 * Time: 1:27 PM
 */

namespace AclBundle\Controller;

use AclBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProfileController
 * @package AclBundle\Controller
 */
class ProfileController extends BaseController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        $user_avatar = new User();
        $fullname = $user_avatar->fullName();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        //dump($user_avatar->getPhoto());
        //die;
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'user_image'=> $user_avatar,
            'fname'=>$fullname,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
//            $file = $user->getPhoto();
//
//            // Generate a unique name for the file before saving it
//            $fileName = md5(uniqid()).'.'.$file->guessExtension();
//
//            // Move the file to the directory where photos are stored
//            $file->move(
//                $this->getParameter('photos_directory'),
//                $fileName
//            );
//
//
//            $user->setPhoto($fileName);
            //dump($user->getPhoto());
            //die;
            $user->getPhoto()->getAbsolutePath();
            $user->getPhoto()->upload();
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
