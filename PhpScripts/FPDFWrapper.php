<?php

require '../FPDF/fpdf.php';

// Due to the fact that in most cases the templates might not fit in just one page, the use of page overflow makes
// it really hard to handle dynamic page by page page formats. Each page will get the values of the whole document
// to work with, which are defined when the PDFWrapper instance is created. ALL UNITS NEED TO MATCH!!! (Use mm)
class FPDFWrapper {

	// Actual pdf object that gets worked on by the wrapper class
	private $pdf;

	// Page size and position variables
	private $leftMargin;
	private $topMargin;
	private $currentLeft;
	private $currentTop;
	private $height;
	private $width;

	// Tracks the actual left margin value in case columns override it
	private $actualLeftMargin;

	// Page style variables
	private $border;
	private $font;
	private $align;

	// Default values
	private $defaultHeight;
	private $defaultWidth;
	private $defaultBorder;
	private $defaultFont;
	private $defaultAlign;
	private $defaultSize;
	private $defaultWeight;
	private $orientation;
	private $measurementUnit;
	private $pageType;

	// Tracks if the parser is normal, getting a header or getting a repeatable section
	private $readState;

	// Track headers defined in the templates
	private $headerTemplate;
	private $usingHeader;
	private $newStartTopWithHeader;

	// Tepeatable templates to recursively pass back to append as needed
	private $repeatableTemplates;

	// The dynamic data index that points to an array that will be used to repeat the template
	private $repeatableValues;
	private $currentRepeatable;

	// Track whether page is single vertical column or two columns
	private $usingColumns;
	private $checkOverflow;

	// Sets default values if not overriden by constructor, nothing is really needed
	function __construct(
		$defaultFont			= null,
		$defaultSize			= null,
		$defaultWeight		= null,
		$defaultAlign			= null,
		$defaultHeight		= null,
		$defaultWidth			= null,
		$defaultBorder		= null,
		$pageType					= null,
		$orientation			= null,
		$measurementUnit	= null,
		$leftMargin				= null,
		$topMargin				= null
	) {
		
		// Seems crazy, but only way to allow null values and still get defaults, in order to only define what needs to be overriden
		// Otherwise, simply changing the page type needs to have all previous values match the defaults, which is not useful
		$defaultFont			= $defaultFont			!= null ? $defaultFont			: 'Arial';
		$defaultSize			= $defaultSize			!= null ? $defaultSize			: 12;
		$defaultWeight		= $defaultWeight		!= null ? $defaultWeight		: '';
		$defaultAlign			= $defaultAlign			!= null ? $defaultAlign			: 'L';
		$defaultHeight		= $defaultHeight		!= null ? $defaultHeight		: 5;
		$defaultWidth			= $defaultWidth			!= null ? $defaultWidth			: 0;
		$defaultBorder		= $defaultBorder		!= null ? $defaultBorder		: 0;

		// pageType and orientation can change, but there is no garantee that anthing complex will work as expected
		$pageType					= $pageType					!= null ? $pageType					: 'Letter';
		$orientation			= $orientation			!= null ? $orientation			: 'P';

		// measurementUnit Should stay this value to work with default margins and have even numbers in mm. I am not sure inches would work correctly in more complex scenarios
		$measurementUnit	= $measurementUnit	!= null ? $measurementUnit	: 'mm';

		// leftMargin in mm leaves 166mm of width to place content on
		$leftMargin				= $leftMargin				!= null ? $leftMargin				: 24.95;

		// topMargin in mm leaves 230mm of height to place content on
		$topMargin				= $topMargin				!= null ? $topMargin				: 24.7;


		// Set actual class variables using what was set above
		$this->leftMargin				= $leftMargin;
		$this->actualLeftMargin	= $leftMargin;
		$this->currentLeft			= $leftMargin;
		$this->topMargin				= $topMargin;
		$this->currentTop				= $topMargin;
		$this->orientation			= $orientation;
		$this->measurementUnit	= $measurementUnit;
		$this->pageType					= $pageType;
		$this->leftMargin				= $leftMargin;
		$this->topMargin				= $topMargin;

		// Make new pdf object that is changed by this class instanc
		$this->pdf = new FPDF($orientation, $measurementUnit, $pageType);
		$this->pdf->SetMargins(	$this->leftMargin, 	$this->topMargin);

		$this->height	= $defaultHeight;
		$this->width	= $defaultWidth;
		$this->border	= $defaultBorder;
		$this->font		= $defaultFont;
		$this->align	= $defaultAlign;

		$this->defaultHeight	= $defaultHeight;
		$this->defaultWidth		= $defaultWidth;
		$this->defaultBorder	= $defaultBorder;
		$this->defaultFont		= $defaultFont;
		$this->defaultAlign		= $defaultAlign;
		$this->defaultSize		= $defaultSize;
		$this->defaultWeight	= $defaultWeight;

		$this->readState							= 'normal';
		$this->usingHeader						= false;
		$this->newStartTopWithHeader	= 0;
		$this->usingColumns						= 0;
		$this->checkOverflow					= false;

		$this->repeatableTemplates = array();
		$this->repeatableValues = array();
		$this->currentRepeatable = -1;
	}
	
	function __destruct() {
		// Maybe things need to be removed here, not really sure?
	}

	// Takes file path instead of text as template by reading file
	function AppendFromFile($filePath, $dynamicData) {
		$file = fopen($filePath, 'r') or die('Unable to open file!');
    $template = fread($file,filesize($filePath));
		fclose($file);
		
		$this->Append($template, $dynamicData);
	}
	
	// Adds the template data to the wrapper's pdf object, using the dynamicData object as needed
	function Append($template, $dynamicData) {

		// Split the template into an array of each line separated by "\n"
		$templateLines = explode("\n", $template);
	
		// Go through each line to pass it to the function that checks what to do with it
		foreach ($templateLines as $line) {
			if ($this->readState == 'normal') {
				$this->CheckLineNormal($line, $dynamicData);
			} else if ($this->readState == 'header') {
				$this->CheckLineHeader($line);
			} else if ($this->readState == 'repeatable') {
				$this->CheckLineRepeatable($line, $dynamicData);
			} else {
				echo 'Unknown read state : ' + $this->readState;
			}
		}
	}

	// Finishes the request by sending the pdf to the user, no modifications can happen after this
	function Output() {
		return $this->pdf->Output();
	}

	// Gives the current y position of the document
	function GetCurrentY() {
		return $this->pdf->GetY() - $this->topMargin;
	}

	function AddPage() {
		$this->pdf->AddPage();
	}

	// Takes a string of text and checks what to do with it
	// Instructions will be interpetted, otherwise the text is added to the pdf using current styles
	private function CheckLineNormal($line, $dynamicData) {

		// Check if the line has content, otherwise add new line to pdf
		if (strlen($line) == 0) {
			$this->pdf->Ln();
		} else {

			// Pass line to check for object and add line if it returns false
			if (!$this->CheckForMetadata($line, $dynamicData)) {
				$this->pdf->SetXY($this->currentLeft, $this->currentTop);
				$this->pdf->MultiCell($this->width, $this->height, $this->ReplaceDynamicData($line, $dynamicData), $this->border, $this->align);

				// Set current top to new position after adding content
				$this->currentTop = $this->pdf->GetY();
			}
		}
	}

	// Adds to header template unless the template is done being defined
	private function CheckLineHeader($line) {

		// Check if the line has content, otherwise add new line to header template
		if (strlen($line) == 0) {
			$this->headerTemplate = $this->headerTemplate . "\n";
		} else {

			// Pass line to check for object and add line if it returns false
			if (!$this->CheckTemplateDefineEnded($line)) {
				$this->headerTemplate = $this->headerTemplate . $line . "\n";
			} else {

				// Remove trailing new line if end of template
				$this->headerTemplate = substr($this->headerTemplate, 0, -2);

				// Reset the header height so it gets set for this template next time it is added
				$this->newStartTopWithHeader = 0;
			}
		}
	}

	// Adds to repeatable template unless the template is done being defined, then iterates over dynamic data
	private function CheckLineRepeatable($line, $dynamicData) {

		// Check if the line has content, otherwise add new line to repeatable template
		if (strlen($line) == 0) {
			$this->repeatableTemplates[$this->currentRepeatable] = $this->repeatableTemplates[$this->currentRepeatable] . "\n";
		} else {

			// Pass line to check for object and add line if it returns false
			if (!$this->CheckTemplateDefineEnded($line)) {
				$this->repeatableTemplates[$this->currentRepeatable] = $this->repeatableTemplates[$this->currentRepeatable] . $line . "\n";
			} else {

				// Remove trailing new line if end of template
				$this->repeatableTemplates[$this->currentRepeatable] = substr($this->repeatableTemplates[$this->currentRepeatable], 0, -2);

				// Since we have the whole template, we can iterate over dynamic data at the repeatable value and recurisevely add the template to the current pdf
				foreach ($dynamicData[$this->repeatableValues[$this->currentRepeatable]] as $dynamicEntry) {
					if ($this->usingColumns > 0) {
						if ($this->checkOverflow) {
							$nextTemplateLength = $this->GetTemplateLength($this->repeatableTemplates[$this->currentRepeatable], $dynamicEntry);
							
							// Check if next item goes too far down the page and do the columns check
							if ($this->GetCurrentY() + $nextTemplateLength > $this->pdf->GetPageHeight() - ($this->topMargin * 2)) {
								if ($this->usingColumns == 1) {
									$this->usingColumns = 2;
									$this->leftMargin = $this->pdf->GetPageWidth() / 2;
									$this->currentTop = $this->usingHeader ? $this->newStartTopWithHeader : $this->topMargin;
									$this->pdf->SetXY($this->currentLeft, $this->currentTop);
								} else if ($this->usingColumns == 2) {
									$this->usingColumns = 1;
									$this->leftMargin = $this->actualLeftMargin;
									$this->AddNewPage($dynamicData);
								}
							}
						} else {

							// Check which column is currently being used and adjust positions or add pages as needed
							if ($this->usingColumns == 1) {
								$this->usingColumns = 2;
								$this->leftMargin = $this->pdf->GetPageWidth() / 2;
								$this->currentTop = $this->usingHeader ? $this->newStartTopWithHeader : $this->topMargin;
								$this->pdf->SetXY($this->currentLeft, $this->currentTop);
							} else if ($this->usingColumns == 2) {
								$this->usingColumns = 1;
								$this->leftMargin = $this->actualLeftMargin;
								$this->AddNewPage($dynamicData);
							} else if ($this->usingColumns == 3) {
								$this->usingColumns = 1;
								$this->leftMargin = $this->actualLeftMargin;
							}
						}
					}

					$this->Append($this->repeatableTemplates[$this->currentRepeatable], $dynamicEntry);
				}

				// Decrease current repeatable to fall back into parent in there is one
				$this->currentRepeatable--;

				// Reset to let each repeatable set again if needed and not let avalue linger
				$this->checkOverflow = false;
			}
		}
	}

	// Takes a line and checks if it's a json object and passes to interpreter functions to set
	// the text style, position and add new pages
	private function CheckForMetadata($line, $dynamicData) {

		// Check if the line starts with a single bracket, meaning instructions need to be interpretted
		if ($line[0] == '{' && $line[1] != '{') {

			// Get an actual object from the json string
			$metadata = json_decode($line, true);

			// Check if read state changes
			if (!$this->CheckForReadStateChange($metadata)) {
				
				// Pass metadata to style and page checking functions
				$this->SetCurrentStyle($metadata);
				$this->CheckNewPageData($metadata, $dynamicData);
			}

			return true;
		} else {
			return false;
		}
	}

	// Checks if a template is done being defined
	private function CheckTemplateDefineEnded($line) {

		// Check if the line starts with a single bracket, meaning instructions need to be interpretted
		if ($line[0] == '{' && $line[1] != '{') {

			// Get an actual object from the json string
			$metadata = json_decode($line, true);

			// Check if read state changes
			if (!$this->CheckForReadStateChange($metadata)) {
				return false;
			}

			return true;
		} else {
			return false;
		}
	}

	// Checks the metadata for a change in read state
	private function CheckForReadStateChange($metadata) {
		if (isset($metadata['startHeader'])) {
			$this->readState = 'header';
			$this->headerTemplate = '';
		} else if (isset($metadata['endHeader'])) {
			$this->readState = 'normal';
		} else if (isset($metadata['startRepeatable']) && $this->readState == 'normal') {
			$this->readState = 'repeatable';
			$this->currentRepeatable++;
			$this->repeatableTemplates[$this->currentRepeatable] = '';
		} else if (isset($metadata['endRepeatable'])) {
			if ($metadata['endRepeatable'] == $this->currentRepeatable) {
				$this->readState = 'normal';
				$this->repeatableValues[$this->currentRepeatable] = $metadata['repeatOn'];
				$this->checkOverflow = isset($metadata['checkOverflow']);
			} else {
				return false;
			}
		} else {
			return false;
		}

		return true;
	}

	// The data parameter is a json parsed line of text with possible style and position changes
	// Sets default style values if a tag is not defined in the json object
	private function SetCurrentStyle($metadata) {
		$this->pdf->SetFont(
			isset($metadata['font'])		? $metadata['font']		: $this->defaultFont,
			isset($metadata['weight'])	? $metadata['weight']	: $this->defaultWeight,
			isset($metadata['size'])		? $metadata['size']		: $this->defaultSize
		);

		$this->border	= isset($metadata['border'])	? $metadata['border']	: $this->border;
		$this->align	= isset($metadata['align'])		? $metadata['align']	: $this->defaultAlign;

		$this->currentLeft	= $this->GetNewLeft($metadata);
		$this->currentTop		= $this->GetNewTop($metadata);
		$this->width				= $this->GetNewWidth($metadata);
		$this->height				= $this->GetNewHeight($metadata);
	}

	// Checks left value in passed data to determine where to start the next line of text
	private function GetNewLeft($metadata) {
		if (isset($metadata['left'])) {
			$availableWidth = $this->pdf->GetPageWidth() - ($this->leftMargin * 2);

			if ($this->usingColumns > 0) {
				$availableWidth /= 2;
			}

			if (substr($metadata['left'], -1) == '%') {
				$this->currentLeft = ((float)substr($metadata['left'], 0, -1) / 100) * $availableWidth + $this->leftMargin;
			} else if ($metadata['left'][0] == '+') {
				$this->currentLeft = $this->currentLeft + (float)substr($metadata['left'], 1);
			} else if ($metadata['left'][0] == '-') {
				$this->currentLeft = $this->currentLeft - (float)substr($metadata['left'], 1);
			} else {
				$this->currentLeft = $this->leftMargin + (float)$metadata['left'];
			}
		} else {
			$this->currentLeft = $this->leftMargin;
		}

		return $this->currentLeft;
	}

	// Checks top value in passed data to determine where to start the next line of text
	private function GetNewTop($metadata) {
		if (isset($metadata['top'])) {
			$availableHeight = $this->pdf->GetPageHeight() - ($this->topMargin * 2);

			if (substr($metadata['top'], -1) == '%') {
				$this->currentTop = ((float)substr($metadata['top'], 0, -1) / 100) * $availableHeight + $this->topMargin;
			} else if ($metadata['top'][0] == '+') {
				$this->currentTop = $this->currentTop + (float)substr($metadata['top'], 1);
			} else if ($metadata['top'][0] == '-') {
				$this->currentTop = $this->currentTop - (float)substr($metadata['top'], 1);
			} else {
				$this->currentTop = $this->topMargin + (float)$metadata['top'];
			}
		} else {
			$this->currentTop = $this->pdf->GetY();
		}

		return $this->currentTop;
	}

	// Checks width value and sets it based on the page width and column status
	private function GetNewWidth($metadata) {
		$availableWidth = $this->pdf->GetPageWidth() - ($this->leftMargin * 2);

		if ($this->usingColumns) {
			$availableWidth /= 2;
		}

		if (isset($metadata['width'])) {
			if (substr($metadata['width'], -1) == '%') {
				return ((float)substr($metadata['width'], 0, -1) / 100) * $availableWidth + $this->leftMargin;
			} else if ($metadata['width'][0] == '+') {
				return $this->width + (float)substr($metadata['width'], 1);
			} else if ($metadata['width'][0] == '-') {
				return $this->width - (float)substr($metadata['width'], 1);
			} else {
				return (float)$metadata['width'];
			}
		} else {
			return $availableWidth;
		}
	}

	// Checks height value and sets it based on the page hight and margins
	private function GetNewHeight($metadata) {
		return isset($metadata['height']) ? $metadata['height'] : $this->defaultHeight;
	}

	// Checks the passed json object for new page data like if the header should be used or columns to separate content
	private function CheckNewPageData($metadata, $dynamicData) {

		// Check if a new page needs to be added
		if (isset($metadata['newPage'])) {
			$this->pdf->AddPage();

			// Reset top for new page
			$this->currentTop = $this->topMargin;

			// Check if the page uses the currently set header
			$this->usingHeader = isset($metadata['useHeader']);

			if ($this->usingHeader) {
				$this->Append($this->headerTemplate, $dynamicData);

				if ($this->newStartTopWithHeader == 0) {
					$this->newStartTopWithHeader = $this->pdf->GetY();
				}
			}

			// Check if the page uses columns, set to 3 in order to let the other stuff know it is starting
			// Values of 1 and 2 are alternated and generate new pages when going from 2 to 1
			$this->usingColumns = isset($metadata['useColumns']) ? 3 : 0;
		}
	}

	// Adds new page using current settings
	private function AddNewPage($dynamicData) {
		$this->pdf->AddPage();

		// Reset top for new page
		$this->currentTop = $this->topMargin;

		if ($this->usingHeader) {
			$tempUsingColumns = $this->usingColumns;
			$this->usingColumns = 0;
			$this->Append($this->headerTemplate, $dynamicData);
			$this->usingColumns = $tempUsingColumns;

			if ($this->newStartTopWithHeader == 0) {
				$this->newStartTopWithHeader = $this->pdf->GetY();
			}
		}
	}

	// Takes a line and replaces the double curly brackets for the value from the passed data
	private function ReplaceDynamicData($line, $dynamicData) {
		$tempLine					= '';
		$characters				= str_split($line);
		$doubleCurlyCount	= 0;
		$dynamicVariable	= '';

		foreach ($characters as $character) {
			if ($doubleCurlyCount == 2 && $character != '}') {
				$dynamicVariable .= $character;
			} else if ($doubleCurlyCount == 1 && strlen($dynamicVariable) > 0) {
				if (isset($dynamicData[$dynamicVariable])) {
					$tempLine .= $dynamicData[$dynamicVariable];
				} else {
					$tempLine .= 'Error getting value for : ' . $dynamicVariable;
				}
				$dynamicVariable = '';
			}

			if ($character == '{' && ($doubleCurlyCount == 0 || $doubleCurlyCount == 1)) {
				$doubleCurlyCount++;
				$dynamicVariable = '';
			} else if ($character == '}' && ($doubleCurlyCount == 1 || $doubleCurlyCount == 2)) {
				$doubleCurlyCount--;
			} else if ($doubleCurlyCount == 0) {
				$tempLine .= $character;
			}
		}

		return $tempLine;
	}

	// Simulates adding the template to a pdf and returns the position of the cursor to get how long the template is
	private function GetTemplateLength($template, $dynamicData) {

		// Make new pdf based on the settings of this one
		$tempPDF = new FPDFWrapper(
			$this->defaultFont,
			$this->defaultSize,
			$this->defaultWeight,
			$this->defaultAlign,
			$this->defaultHeight,
			$this->defaultWidth,
			$this->defaultBorder,
			$this->pageType,
			$this->orientation,
			$this->measurementUnit,
			$this->leftMargin,
			$this->topMargin
		);

		$tempPDF->AddPage();
		$tempPDF->Append($template, $dynamicData);

		return $tempPDF->GetCurrentY();
	}
}

?>
