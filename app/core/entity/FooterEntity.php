<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;
use App\model\FooterModel;

class FooterEntity extends DataAccessManager
{
    protected static string $table = 'footer';
    protected static FooterEntity $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): FooterEntity
    {
        if (!isset(self::$instance)) {
            self::$instance = new FooterEntity();
        }
        return self::$instance;
    }

    public function persoFooter(FooterModel $footerModel): void
    {
        $statement = "UPDATE `footer` SET `firstname`=?, `lastname`=?, `address`=?, `phoneNumber`=?, `email`=?,
                    `facebookLink`=?, `twitterLink`=?, `instagramLink`=?, `linkedinLink`=?, `githubLink`=?";
        $values = [$footerModel->getFirstname(), $footerModel->getLastname(), $footerModel->getAddress(),
            $footerModel->getPhoneNumber(), $footerModel->getEmail(), $footerModel->getFacebookLink(),
            $footerModel->getTwitterLink(), $footerModel->getInstagramLink(), $footerModel->getLinkedinLink(),
            $footerModel->getGithubLink()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }

    public function getFooter(): object
    {
        return $this->one("SELECT * FROM `footer`");
    }
}
