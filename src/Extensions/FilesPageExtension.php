<?php

namespace PurpleSpider\BasicFilesPage;


use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Colymba\BulkUpload\BulkUploader;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridField;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
use PurpleSpider\BasicFilesPage\FilesPageFile;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class FilesPageExtension extends DataExtension
{
  
    private static $db = [
      "SortBy" => "Enum('Custom,Created,Title','Custom')",
      "SortOrder" => "Enum('ASC,DESC','ASC')",
    ];
    
    // One gallery page has many gallery images
    private static $has_many = array(
    'Files' => FilesPageFile::class
    );
    
    private static $owns = [
      "Files"
    ];
        
    public function updateCMSFields(FieldList $fields)
    {
        if (!$gridfieldCMSTab = $this->owner->config()->get('files-cms-tab')) {
          $gridfieldCMSTab = "Files";
        }
        
        $insertGalleryBefore = null;
        if ($gridfieldCMSTab == "Main") {
          $insertGalleryBefore = "Metadata";
        }
        
      
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new BulkUploader());
        $bulkUpload = $gridFieldConfig->getComponentByType(BulkUploader::class);
        $bulkUpload->setUfSetup('setFolderName', "Managed/FilesPages/".$this->owner->ID."-".$this->owner->URLSegment);
        $gridFieldConfig->removeComponentsByType(GridFieldPaginator::class);
        
        if ($this->owner->SortBy == "Custom" || !$this->owner->SortBy) {
          $gridFieldConfig->addComponent(GridFieldOrderableRows::create()->setSortField('SortOrder'));
        }
        $gridFieldConfig->addComponent(new GridFieldPaginator(100));
        $gridFieldConfig->removeComponentsByType(GridFieldAddNewButton::class);
        
        $gridfield = new GridField("Files", "Files", $this->owner->Files()->sort($this->SortOrder()), $gridFieldConfig);
        $fields->addFieldToTab('Root.'.$gridfieldCMSTab, HeaderField::create('addHeader','Add Files'),$insertGalleryBefore);
        
        // Workaround for SilverStripe 4 bug which errors history view on a has_many GridField
        // https://github.com/silverstripe/silverstripe-framework/issues/3357#issuecomment-405795864
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if (strpos($url,'history') === false) {
            $fields->addFieldToTab('Root.'.$gridfieldCMSTab, $gridfield,$insertGalleryBefore);
        }
        
        if ($this->owner->Files()->Count()) {
          $fields->addFieldToTab('Root.'.$gridfieldCMSTab, HeaderField::create('sortHeader','File Sorting'),$insertGalleryBefore);
          $fields->addFieldToTab("Root.".$gridfieldCMSTab, DropdownField::create('SortBy', 'Sort By', array("Custom"=>"Drag & Drop (Manually)","Created"=>"Date Added","Title"=>"Link Title (Alphabetically)")));
          if ($this->owner->SortBy != "Custom") {
            $fields->addFieldToTab("Root.".$gridfieldCMSTab, DropdownField::create('SortOrder', 'Sort Direction', array("ASC"=>"Ascending","DESC"=>"Descending")));
          }
        }
        
        return $fields;
    }
    
    public function SortOrder()
    {
      if ($this->owner->SortBy && $this->owner->SortBy != "Custom") {
        return $this->owner->SortBy." ".$this->owner->SortOrder;
      }
      
      return "SortOrder ASC";
    }
    
    public function sortedFiles()
    {
        return $this->owner->Files()->sort($this->SortOrder());
    }
}
