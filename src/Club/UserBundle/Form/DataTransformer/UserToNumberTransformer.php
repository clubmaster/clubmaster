<?php

namespace Club\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;

class UserToNumberTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  User|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getMemberNumber();
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $member_number
     * @return User|null
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($member_number)
    {
        if (!$member_number) {
            return null;
        }

        $user = $this->om
            ->getRepository('ClubUserBundle:User')
            ->findOneBy(array('member_number' => $member_number))
        ;

        if (null === $user) {
            try {
            $user = $this->om
                ->getRepository('ClubUserBundle:User')
                ->getOneBySearch(array(
                    'query' => $member_number
                ));
            } catch (NonUniqueResultException $e) {
                throw new TransformationFailedException($e->getMessage());
            }

            if (null === $user) {
                throw new TransformationFailedException(sprintf(
                    'An user with number "%s" does not exist!',
                    $member_number
                ));
            }
        }

        return $user;
    }
}
