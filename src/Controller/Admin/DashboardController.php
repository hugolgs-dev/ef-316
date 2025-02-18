<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Controller\Admin\PostCrudController;
use App\Controller\Admin\CommentCrudController;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{


    private AuthorizationCheckerInterface $authChecker;

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if (!$this->authChecker->isGranted('ROLE_ADMIN')) {

            $this->addFlash('error', 'Vous n\'êtes pas administrateur, vous n\'avez pas le droit d\'accéder à cette page.');

            return $this->redirectToRoute('home');

        }
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ciel 316');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToDashboard('Sujets', 'fa fa-bullhorn', Post::class);
        yield MenuItem::linkToDashboard('Réponses', 'fa fa-envelope', Comment::class);
        yield MenuItem::linkToDashboard('Users', 'fa fa-users', User::class);

    }
}
