# Basic Files Page Module for SilverStripe

## Introduction

Provides basic files page functionality to a SilverStripe site. 

Designed to provide a simple, fool-proof way for users to add multiple file download links to a single page.

A "Files" tab in the CMS, allows CMS users to bulk upload multiple files which are then assigned to the page. The files are managed in a GridField, each file item contains a "Link Title" and the File itself. The template then displays links to all the files.

This module has been designed to have just the minimum required features, to avoid bloat, but can be easily extended to add new fields if required.

Note: This is similar to my [File Listing Page](https://github.com/purplespider/silverstripe-file-listing) module, but this one has the files associated with the page, rather than a folder, so the files are managed while editing the page, and not in the Files area. This module also allows you to set the order the download links display in, but can't support a folder hierarchy, only a flat list of links. 

## Maintainer Contact ##
 * James Cocker (ssmodulesgithub@pswd.biz)
 
## Requirements
 * Silverstripe 4.1+
 
## Installation Instructions

1. Run `composer require purplespider/basic-files-page`
2. Do a dev/build

## Usage Instructions
1. Log in the CMS, and create a new Files Page.
2. From the page's Files tab you can upload one or more files.
3. You can then click on a file to customise the link text, or reorder the files.

## Screenshot
![Screenshot](http://pswd.biz/ssmodules/basic-files-page/basic-files-page.png)

## Credits
 * Uses @colymba's BulkUploader from [GridFieldBulkEditingTools](https://github.com/colymba/GridFieldBulkEditingTools) for the bulk uploading feature.
 * Uses @symbiote's GridFieldOrderableRows from [gridfieldextensions](https://github.com/symbiote/silverstripe-gridfieldextensions) for the ability to drag and drop the files to reorder.