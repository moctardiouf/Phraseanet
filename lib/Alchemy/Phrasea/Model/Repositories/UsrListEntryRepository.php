<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2013 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Model\Repositories;

use Alchemy\Phrasea\Model\Entities\UsrList;
use Alchemy\Phrasea\Model\Entities\UsrListEntry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * UsrListEntryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsrListEntryRepository extends EntityRepository
{

    /**
     * Get all lists entries matching a given User
     *
     * @param \User_Adapter $user
     * @param type          $like
     */
    public function findUserList(\User_Adapter $user)
    {
        $dql = 'SELECT e FROM Alchemy\Phrasea\Model\Entities\UsrListEntry e
            WHERE e.usr_id = :usr_id';

        $params = [
            'usr_id' => $user->get_id(),
        ];

        $query = $this->_em->createQuery($dql);
        $query->setParameters($params);

        return $query->getResult();
    }

    public function findEntryByListAndEntryId(UsrList $list, $entry_id)
    {
        $entry = $this->find($entry_id);

        if (!$entry) {
            throw new NotFoundHttpException('Entry not found');
        }

        /* @var $entry UsrListEntry */
        if ($entry->getList()->getId() != $list->getId()) {
            throw new AccessDeniedHttpException('Entry mismatch list');
        }

        return $entry;
    }

    public function findEntryByListAndUsrId(UsrList $list, $usr_id)
    {
        $dql = 'SELECT e FROM Alchemy\Phrasea\Model\Entities\UsrListEntry e
              JOIN e.list l
            WHERE e.usr_id = :usr_id AND l.id = :list_id';

        $params = [
            'usr_id'  => $usr_id,
            'list_id' => $list->getId(),
        ];

        $query = $this->_em->createQuery($dql);
        $query->setParameters($params);

        $entry = $query->getResult();

        if (!$entry) {
            throw new NotFoundHttpException('Entry not found');
        }

        return $query->getSingleResult();
    }
}
