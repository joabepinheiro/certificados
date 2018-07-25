<?php
namespace Application\Form\Validator;

use Zend\Validator\AbstractValidator;

class DbUniqueObject extends AbstractValidator
{

    const INVALID = 'objectAlreadyExists';

    protected $messageTemplates = array(
        self::INVALID => "Field value must be unique in the database (id=%id%)"
    );

    protected $messageVariables = array(
        'id' => array(
            'options' => 'id'
        )
    );

    protected $options = array(
        'em',
        'entity',
        'field',
        'exclude_id'
    );

    public function __construct($options = null)
    {
        $this->options = $options;
        parent::__construct($options);
    }

    public function isValid($value)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('t')
            ->from($this->entity, 't')
            ->where('t.' . $this->field . '= :field')
            ->setParameter('field', $value);
        
        if (boolval($this->exclude_id)) {
            $qb->andWhere('t.id <> :id');
            $qb->setParameter('id', $this->exclude_id);
        }
        $result = $qb->getQuery()->getResult();
        if (boolval($result)) {
            $this->options['id'] = $result[0]->getID();
            $this->error(self::INVALID);
            return false;
        }
        return true;
    }

    public function __get($property)
    {
        return array_key_exists($property, $this->options) ? $this->options[$property] : parent::__get($property);
    }
}