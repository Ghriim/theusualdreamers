<?php

namespace CommonBundle\Controller\Traits;

use BlogBundle\Entity\Comment;
use BlogBundle\Entity\Post;
use BlogBundle\Repository\CommentRepository;
use BlogBundle\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class RepositoryTrait
 *
 * @package CommonBundle\Controller\Traits
 */
trait RepositoryTrait
{
    /**
     * Gets Doctrine Registry. Alias to fix IDE file navigation
     *
     * @return Registry
     */
    abstract public function getDoctrine ();

    /**
     * @return PostRepository
     */
    protected function getPostRepository ()
    {
        return $this->getDoctrine()->getRepository(Post::class);
    }

    /**
     * @return CommentRepository
     */
    protected function getCommentRepository ()
    {
        return $this->getDoctrine()->getRepository(Comment::class);
    }
}