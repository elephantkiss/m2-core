<?php

declare(strict_types=1);

namespace ElephantKiss\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\User\Model\ResourceModel\User;
use Magento\User\Api\Data\UserInterfaceFactory;

class Data extends AbstractHelper
{
    /**
     * @var UserInterfaceFactory
     */
    protected $userFactory;

    /**
     * @var User
     */
    protected $resourceUser;

    /**
     * @param UserInterfaceFactory $userFactory
     * @param User $resourceUser
     * @param Context $context
     */
    public function __construct(
        UserInterfaceFactory $userFactory,
        User $resourceUser,
        Context $context
    ) {
        $this->userFactory = $userFactory;
        $this->resourceUser = $resourceUser;
        parent::__construct($context);
    }

    /**
     * @param $userId
     * @return string
     */
    public function getUserName($userId): string
    {
        $user = $this->userFactory->create();
        $this->resourceUser->load($user, $userId);

        if (!$user->getId()) {
            return 'No data';
        }

        $delimiter = ' ';
        if (!$user->getFirstname() || !$user->getLastname()) {
            $delimiter = '';
        }

        return $user->getFirstname() . $delimiter . $user->getLastname();
    }
}
