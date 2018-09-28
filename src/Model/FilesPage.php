<?php

namespace PurpleSpider\BasicFilesPage;
use Page;
use SilverStripe\Forms\LiteralField;

class FilesPage extends Page
{
    private static $description = "Allows you to easily add multiple file download links to the page";
    private static $icon = 'purplespider/basic-files-page:client/dist/images/page_white_put-file.gif';
    private static $singular_name = "Files Page";
    private static $table_name = "FilesPage";

    public function getCMSFields()
    {
      if (!$gridfieldCMSTab = $this->config()->get('files-cms-tab')) {
        $gridfieldCMSTab = "Files";
      }
        
        $fields = parent::getCMSFields();
        
        if (!$this->Files()->count()) {
          $fields->addFieldToTab("Root.Main", LiteralField::create('filesIntro', '<h2>Add multiple file download links to this page via the above <strong>'.$gridfieldCMSTab.'</strong> tab.</h2>'),'Title');
        }
        
        return $fields;
    }
}
