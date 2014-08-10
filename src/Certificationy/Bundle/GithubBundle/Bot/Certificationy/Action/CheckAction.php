<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action;

use Certificationy\Bundle\GithubBundle\Bot\Common\Action\GenericAction;
use Certificationy\Bundle\GithubBundle\Api\Client;

class CheckAction extends GenericAction
{
    /**
     * @var Array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param Client $client
     * @param array  $data
     * @param string $basePath
     */
    public function __construct(Client $client, array $data, $basePath)
    {
        parent::__construct($client, $data);

        $this->errors = array(
            'total' => 0,
            'structure' => array(),
            'pattern' => array(),
            'parser' => array()
        );

        $this->basePath = $basePath;
    }

    /**
     * @param string $type
     * @param string $message
     * @param array  $context
     */
    public function addError($type, $message, array $context = array())
    {
        if (!isset($this->errors[$type])) {
            $this->errors[$type] = array();
        }

        $this->errors[$type][] = array(
            'message' => $message,
            'context' => $context
        );

        $this->errors['total']++;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return Array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}