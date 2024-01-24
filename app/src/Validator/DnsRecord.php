<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DnsRecord extends Constraint
{
    public const TYPES = ['A', 'MX', 'NS', 'SOA', 'PTR', 'CNAME', 'AAAA', 'A6', 'SRV', 'NAPTR', 'TXT', 'ANY'];

    public string $message = 'Non-existent hostname {{ value }}';

    public string $type = 'MX';

    public function __construct(string $message = null, string $type = null, mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;

        $this->type = $type ?? $this->type;
    }
}
