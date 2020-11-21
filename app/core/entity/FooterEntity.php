<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class FooterEntity extends DataAccessManager
{
    protected static string $table = 'footer';
    protected static FooterEntity $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new FooterEntity();
        }
        return self::$instance;
    }

    public function persoFooter(object $footerModel): void
    {
        $statement = "UPDATE `footer` SET `firstname`=?, `lastname`=?, `address`=?, `phoneNumber`=?, `email`=?, `facebookLink`=?,
                  `twitterLink`=?, `instagramLink`=?, `linkedinLink`=?, `githubLink`=?";
        $values = [$footerModel->getFirstname(), $footerModel->getLastname(), $footerModel->getAddress(),
            $footerModel->getPhoneNumber(), $footerModel->getEmail(), $footerModel->getFacebookLink(),
            $footerModel->getTwitterLink(), $footerModel->getInstagramLink(), $footerModel->getLinkedinLink(),
            $footerModel->getGithubLink()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }
}
