<?php
namespace AclBundle\Controller;
use AclBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * User controller.
 *
 * @Route("admin/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AclBundle:User')->findAll();
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }
    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AclBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->getRoles();
            $user->getPhoto()->upload();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_user_show', array('id' => $user->getId()));
        }
        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $fullname = $user->fullName();
        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
            'fname' => $fullname
        ));
    }
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AclBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        //** @var $formFactory FactoryInterface */
        //change password = fos_user.change_password.form.factory
        //$formFactory = $this->get('fos_user.profile.form.factory');
        //$editForm = $formFactory->createForm();
        //$editForm->setData($user);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Getting the variable of the form
            $selectedUser = $user->getId();
            // Getting the user infos
            $editUser = $this->getDoctrine()->getRepository('AclBundle:User')->find($selectedUser);
            // Using the UserManager (from the FOSUserBundle)
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($editUser->getUsername());
            $role = $editForm['roles']->getData();
            // Changing the role of the user
            $user->setRoles(array($role));
            //$user->setRoles(array($selectedUser['roles']));
            // Updating the user
            $user->getPhoto()->getAbsolutePath();
            $user->getPhoto()->upload();
            $userManager->updateUser($user);



            // Generate a unique name for the file before saving it
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_user_edit', array('id' => $user->getId()));
        }
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('admin_user_index');
    }
    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}