<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DnsRecordValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof DnsRecord) {
            throw new UnexpectedTypeException($constraint, DnsRecord::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!in_array($constraint->type, DnsRecord::TYPES)) {
            throw new UnexpectedValueException($constraint->type, implode(' ,',DnsRecord::TYPES));
        }

        $hostname = parse_url($value, PHP_URL_HOST);
        if (!checkdnsrr($hostname, $constraint->type)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $hostname)
                ->addViolation();
        }
    }
}
