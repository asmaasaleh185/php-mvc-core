<?php

namespace corepackage\phpmvc;

use corepackage\phpmvc\db\DbModel;

abstract class UserModel extends DbModel{
    abstract public function getDisplayName(): string;
}