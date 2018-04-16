<?php

namespace PurpleSpider\BasicFilesPage;


use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;


class FilesPageFile extends DataObject
{
 
    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)'
    ];
    
    private static $has_one = [
        'File' => File::class,
        'FilesPage' => FilesPage::class
    ];
    
    private static $summary_fields = [
       'Title' => 'Link Title',
       'File.Name' => 'Filename',
       'File.Extension' => 'Type',
       'File.Size' => 'Size',
       'File.LastEdited' => 'File Added',
       // 'File.get_icon_for_extension' => 'Icon',
    ];

    private static $table_name = 'FilesPageFile';
    private static $default_sort = "SortOrder ASC, Created ASC";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->removeFieldFromTab("Root.Main", "SortOrder");
        $fields->removeFieldFromTab("Root.Main", "FilesPageID");
        
        $fields->addFieldToTab("Root.Main", TextField::create('Title', 'Link Title'),'File');
        
        return $fields;
    }
    
    protected function onBeforeWrite()
    {

  		if (!$this->SortOrder) {
  			$this->SortOrder = FilesPageFile::get()->max('SortOrder') + 1;
  		}
      
      if (!$this->Title && $this->File()->exists()) {
        $this->Title = $this->File()->Title;
      }
  		
  		parent::onBeforeWrite();
  	}
    
    public function getFullFilename()
    {
      return $this->File()->Title.".".$this->File()->Extension;
    }

    public function canCreate($member = null, $context = array())
    {
        return true;
    }
    
    public function canEdit($members = null)
    {
        return true;
    }
    
    public function canDelete($members = null)
    {
        return true;
    }
    
    public function canView($members = null)
    {
        return true;
    }
}
