<?php


namespace OrSdk\Models\Com\Contacts;

use OrSdk\Util\BasicEnum;

abstract class EndpointType extends BasicEnum
{
    const gln   	= 'gln';
    const dk_cvr	= 'dk:cvr';
}