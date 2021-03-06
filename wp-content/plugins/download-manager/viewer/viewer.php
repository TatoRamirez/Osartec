<?php

?>
<!DOCTYPE html>

<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="google" content="notranslate">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Visor de archivos PDF</title>


    <link rel="stylesheet" href="viewer.css">

    <script src="compatibility.js"></script>



<!-- This snippet is used in production (included from viewer.html) -->
<link rel="resource" type="application/l10n" href="locale/locale.properties">
<script src="l10n.js"></script>
<script src="build/pdf.js"></script>

<?php
$urlpath=$_GET["dl"];
?>
    <script src="debugger.js"></script>
	<script type="text/javascript">
      <!--// 
      urlpdf = '<?php echo $urlpath;?>';
      //-->
    </script>
	
    <script src="viewer.js"></script>

  </head>

  <body tabindex="1" class="loadingInProgress">
    <div id="outerContainer">

      <div id="sidebarContainer">
        <div id="toolbarSidebar">
          <div class="splitToolbarButton toggled">
            <button id="viewThumbnail" class="toolbarButton group toggled" title="Mostrar miniaturas" tabindex="2" data-l10n-id="thumbs">
               <span data-l10n-id="thumbs_label">Miniaturas</span>
            </button>
            <button id="viewOutline" class="toolbarButton group" title="Mostrar esquema del documento" tabindex="3" data-l10n-id="outline">
               <span data-l10n-id="outline_label">Esquema del documento</span>
            </button>
            <button id="viewAttachments" class="toolbarButton group" title="Archivos adjuntos" tabindex="4" data-l10n-id="attachments">
               <span data-l10n-id="attachments_label">Archivos adjuntos</span>
            </button>
          </div>
        </div>
        <div id="sidebarContent">
          <div id="thumbnailView">
          </div>
          <div id="outlineView" class="hidden">
          </div>
          <div id="attachmentsView" class="hidden">
          </div>
        </div>
      </div>  <!-- sidebarContainer -->

      <div id="mainContainer">
        <div class="findbar hidden doorHanger hiddenSmallView" id="findbar">
          <label for="findInput" class="toolbarLabel" data-l10n-id="find_label">Buscar:</label>
          <input id="findInput" class="toolbarField" tabindex="91">
          <div class="splitToolbarButton">
            <button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="92" data-l10n-id="find_previous">
              <span data-l10n-id="find_previous_label">Anterior</span>
            </button>
            <div class="splitToolbarButtonSeparator"></div>
            <button class="toolbarButton findNext" title="" id="findNext" tabindex="93" data-l10n-id="find_next">
              <span data-l10n-id="find_next_label">Siguiente</span>
            </button>
          </div>
          <input type="checkbox" id="findHighlightAll" class="toolbarField" tabindex="94">
          <label for="findHighlightAll" class="toolbarLabel" data-l10n-id="find_highlight">Resaltar todo</label>
          <input type="checkbox" id="findMatchCase" class="toolbarField" tabindex="95">
          <label for="findMatchCase" class="toolbarLabel" data-l10n-id="find_match_case_label">Corresponder may&uacute;sculas y min&uacute;sculas</label>
          <span id="findResultsCount" class="toolbarLabel hidden"></span>
          <span id="findMsg" class="toolbarLabel"></span>
        </div>  <!-- findbar -->

        <div id="secondaryToolbar" class="secondaryToolbar hidden doorHangerRight">
          <div id="secondaryToolbarButtonContainer">
            <button id="secondaryPresentationMode" class="secondaryToolbarButton presentationMode visibleLargeView" title="Switch to Presentation Mode" tabindex="51" data-l10n-id="presentation_mode">
              <span data-l10n-id="presentation_mode_label">Modo de preentaci&oacute;n</span>
            </button>

            <button id="secondaryOpenFile" class="secondaryToolbarButton openFile visibleLargeView" title="Abrir Archivo" tabindex="52" data-l10n-id="open_file">
              <span data-l10n-id="open_file_label">Abrir</span>
            </button>

            <button id="secondaryPrint" class="secondaryToolbarButton print visibleMediumView" title="Imprimir" tabindex="53" data-l10n-id="print">
              <span data-l10n-id="print_label">Imprimir</span>
            </button>

            <button id="secondaryDownload" class="secondaryToolbarButton download visibleMediumView" title="Descargar" tabindex="54" data-l10n-id="download">
              <span data-l10n-id="download_label">Descargar</span>
            </button>

            <a href="#" id="secondaryViewBookmark" class="secondaryToolbarButton bookmark visibleSmallView" title="Vista actual (copiar o abrir en nueva ventana)" tabindex="55" data-l10n-id="bookmark">
              <span data-l10n-id="bookmark_label">Vista actual</span>
            </a>

            <div class="horizontalToolbarSeparator visibleLargeView"></div>

            <button id="firstPage" class="secondaryToolbarButton firstPage" title="Ir a primera p&aacute;gina" tabindex="56" data-l10n-id="first_page">
              <span data-l10n-id="first_page_label">Ir a primera p&aacute;gina</span>
            </button>
            <button id="lastPage" class="secondaryToolbarButton lastPage" title="Ir a &uacute;ltima p&aacute;gina" tabindex="57" data-l10n-id="last_page">
              <span data-l10n-id="last_page_label">Ir a &uacute;ltima p&aacute;gina</span>
            </button>

            <div class="horizontalToolbarSeparator"></div>

            <button id="pageRotateCw" class="secondaryToolbarButton rotateCw" title="Rotar a la derecha" tabindex="58" data-l10n-id="page_rotate_cw">
              <span data-l10n-id="page_rotate_cw_label">Rotar a la derecha</span>
            </button>
            <button id="pageRotateCcw" class="secondaryToolbarButton rotateCcw" title="Rotar a la izquierda" tabindex="59" data-l10n-id="page_rotate_ccw">
              <span data-l10n-id="page_rotate_ccw_label">Rotar a la izquierda</span>
            </button>

            <div class="horizontalToolbarSeparator"></div>

            <button id="toggleHandTool" class="secondaryToolbarButton handTool" title="Herramienta manual" tabindex="60" data-l10n-id="hand_tool_enable">
              <span data-l10n-id="hand_tool_enable_label">Herramienta manual</span>
            </button>

            <div class="horizontalToolbarSeparator"></div>

            <button id="documentProperties" class="secondaryToolbarButton documentProperties" title="Propiedades del documento???" tabindex="61" data-l10n-id="document_properties">
              <span data-l10n-id="document_properties_label">Propiedades del documento???</span>
            </button>
          </div>
        </div>  <!-- secondaryToolbar -->

        <div class="toolbar">
          <div id="toolbarContainer">
            <div id="toolbarViewer">
              <div id="toolbarViewerLeft">
                <button id="sidebarToggle" class="toolbarButton" title="Alternar barra lateral" tabindex="11" data-l10n-id="toggle_sidebar">
                  <span data-l10n-id="toggle_sidebar_label">Alternar barra lateral</span>
                </button>
                <div class="toolbarButtonSpacer"></div>
                <button id="viewFind" class="toolbarButton group hiddenSmallView" title="Buscar en Documento" tabindex="12" data-l10n-id="findbar">
                   <span data-l10n-id="findbar_label">Buscar</span>
                </button>
                <div class="splitToolbarButton">
                  <button class="toolbarButton pageUp" title="P&aacute;gina anterior" id="previous" tabindex="13" data-l10n-id="previous">
                    <span data-l10n-id="previous_label">Anterior</span>
                  </button>
                  <div class="splitToolbarButtonSeparator"></div>
                  <button class="toolbarButton pageDown" title="P&aacute;gina siguiente" id="next" tabindex="14" data-l10n-id="next">
                    <span data-l10n-id="next_label">Siguiente</span>
                  </button>
                </div>
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">P&aacute;gina: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1" tabindex="15">
                <span id="numPages" class="toolbarLabel"></span>
              </div>
              <div id="toolbarViewerRight">
                <button id="presentationMode" class="toolbarButton presentationMode hiddenLargeView" title="Cambiar modo de presentaci&oacute;n" tabindex="31" data-l10n-id="presentation_mode">
                  <span data-l10n-id="presentation_mode_label">Modo de presentaci&oacute;n</span>
                </button>

                <button id="openFile" class="toolbarButton openFile hiddenLargeView" title="Abrir archivo" tabindex="32" data-l10n-id="open_file">
                  <span data-l10n-id="open_file_label">Abrir</span>
                </button>

                <button id="print" class="toolbarButton print hiddenMediumView" title="Imprimir" tabindex="33" data-l10n-id="print">
                  <span data-l10n-id="print_label">Imprimir</span>
                </button>

                <button id="download" class="toolbarButton download hiddenMediumView" title="Descargar" tabindex="34" data-l10n-id="download">
                  <span data-l10n-id="download_label">Descargar</span>
                </button>
                <a href="#" id="viewBookmark" class="toolbarButton bookmark hiddenSmallView" title="Vista actual (copiar o abrir en nueva ventana)" tabindex="35" data-l10n-id="bookmark">
                  <span data-l10n-id="bookmark_label">Vista actual</span>
                </a>

                <div class="verticalToolbarSeparator hiddenSmallView"></div>

                <button id="secondaryToolbarToggle" class="toolbarButton" title="Herramientas" tabindex="36" data-l10n-id="tools">
                  <span data-l10n-id="tools_label">Herramientas</span>
                </button>
              </div>
              <div class="outerCenter">
                <div class="innerCenter" id="toolbarViewerMiddle">
                  <div class="splitToolbarButton">
                    <button id="zoomOut" class="toolbarButton zoomOut" title="Alejar" tabindex="21" data-l10n-id="zoom_out">
                      <span data-l10n-id="zoom_out_label">Alejar</span>
                    </button>
                    <div class="splitToolbarButtonSeparator"></div>
                    <button id="zoomIn" class="toolbarButton zoomIn" title="Acercarse" tabindex="22" data-l10n-id="zoom_in">
                      <span data-l10n-id="zoom_in_label">Acercarse</span>
                     </button>
                  </div>
                  <span id="scaleSelectContainer" class="dropdownToolbarButton">
                     <select id="scaleSelect" title="Zoom" tabindex="23" data-l10n-id="zoom">
                      <option id="pageAutoOption" title="" value="auto" selected="selected" data-l10n-id="page_scale_auto">Zoom autom&aacute;tico</option>
                      <option id="pageActualOption" title="" value="page-actual" data-l10n-id="page_scale_actual">Tama&ntilde;o actual</option>
                      <option id="pageFitOption" title="" value="page-fit" data-l10n-id="page_scale_fit">Ajustar a p&aacute;gina</option>
                      <option id="pageWidthOption" title="" value="page-width" data-l10n-id="page_scale_width">Tama&ntilde;o completo</option>
                      <option id="customScaleOption" title="" value="custom"></option>
                      <option title="" value="0.5" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 50 }'>50%</option>
                      <option title="" value="0.75" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 75 }'>75%</option>
                      <option title="" value="1" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 100 }'>100%</option>
                      <option title="" value="1.25" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 125 }'>125%</option>
                      <option title="" value="1.5" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 150 }'>150%</option>
                      <option title="" value="2" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 200 }'>200%</option>
                      <option title="" value="3" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 300 }'>300%</option>
                      <option title="" value="4" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 400 }'>400%</option>
                    </select>
                  </span>
                </div>
              </div>
            </div>
            <div id="loadingBar">
              <div class="progress">
                <div class="glimmer">
                </div>
              </div>
            </div>
          </div>
        </div>

        <menu type="context" id="viewerContextMenu">
          <menuitem id="contextFirstPage" label="First Page"
                    data-l10n-id="first_page"></menuitem>
          <menuitem id="contextLastPage" label="Last Page"
                    data-l10n-id="last_page"></menuitem>
          <menuitem id="contextPageRotateCw" label="Rotate Clockwise"
                    data-l10n-id="page_rotate_cw"></menuitem>
          <menuitem id="contextPageRotateCcw" label="Rotate Counter-Clockwise"
                    data-l10n-id="page_rotate_ccw"></menuitem>
        </menu>

        <div id="viewerContainer" tabindex="0">
          <div id="viewer" class="pdfViewer"></div>
        </div>

        <div id="errorWrapper" hidden='true'>
          <div id="errorMessageLeft">
            <span id="errorMessage"></span>
            <button id="errorShowMore" data-l10n-id="error_more_info">
              M&aacute;s informaci&oacute;n
            </button>
            <button id="errorShowLess" data-l10n-id="error_less_info" hidden='true'>
              Menos informaci&oacute;n
            </button>
          </div>
          <div id="errorMessageRight">
            <button id="errorClose" data-l10n-id="error_close">
              Cerrar
            </button>
          </div>
          <div class="clearBoth"></div>
          <textarea id="errorMoreInfo" hidden='true' readonly="readonly"></textarea>
        </div>
      </div> <!-- mainContainer -->

      <div id="overlayContainer" class="hidden">
        <div id="passwordOverlay" class="container hidden">
          <div class="dialog">
            <div class="row">
              <p id="passwordText" data-l10n-id="password_label">Escriba contrase&ntilde;a para abrir documento:</p>
            </div>
            <div class="row">
              <!-- The type="password" attribute is set via script, to prevent warnings in Firefox for all http:// documents. -->
              <input id="password" class="toolbarField">
            </div>
            <div class="buttonRow">
              <button id="passwordCancel" class="overlayButton"><span data-l10n-id="password_cancel">Cancelar</span></button>
              <button id="passwordSubmit" class="overlayButton"><span data-l10n-id="password_ok">OK</span></button>
            </div>
          </div>
        </div>
        <div id="documentPropertiesOverlay" class="container hidden">
          <div class="dialog">
            <div class="row">
              <span data-l10n-id="document_properties_file_name">Nombre de archivo:</span> <p id="fileNameField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_file_size">Tama??o del archivo:</span> <p id="fileSizeField">-</p>
            </div>
            <div class="separator"></div>
            <div class="row">
              <span data-l10n-id="document_properties_title">T&iacute;tulo:</span> <p id="titleField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_author">Autor:</span> <p id="authorField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_subject">Tema:</span> <p id="subjectField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_keywords">Palabras clave:</span> <p id="keywordsField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_creation_date">Fecha de creaci&oacute;n:</span> <p id="creationDateField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_modification_date">Fecha de modificaci&oacute;n:</span> <p id="modificationDateField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_creator">Creador:</span> <p id="creatorField">-</p>
            </div>
            <div class="separator"></div>
            <div class="row">
              <span data-l10n-id="document_properties_producer">Productor PDF:</span> <p id="producerField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_version">Versi&oacute;n PDF:</span> <p id="versionField">-</p>
            </div>
            <div class="row">
              <span data-l10n-id="document_properties_page_count">N&uacute;mero de p&aacute;ginas:</span> <p id="pageCountField">-</p>
            </div>
            <div class="buttonRow">
              <button id="documentPropertiesClose" class="overlayButton"><span data-l10n-id="document_properties_close">Cerrar</span></button>
            </div>
          </div>
        </div>
      </div>  <!-- overlayContainer -->

    </div> <!-- outerContainer -->
	
    <div id="printContainer"></div>
	
	<div id="mozPrintCallback-shim" hidden>
	  <style>
	@media print {
	  #printContainer div {
		page-break-after: always;
		page-break-inside: avoid;
	  }
	}
	  </style>
	  <style scoped>
	#mozPrintCallback-shim {
	  position: fixed;
	  top: 0;
	  left: 0;
	  height: 100%;
	  width: 100%;
	  z-index: 9999999;

	  display: block;
	  text-align: center;
	  background-color: rgba(0, 0, 0, 0.5);
	}
	#mozPrintCallback-shim[hidden] {
	  display: none;
	}
	@media print {
	  #mozPrintCallback-shim {
		display: none;
	  }
	}

	#mozPrintCallback-shim .mozPrintCallback-dialog-box {
	  display: inline-block;
	  margin: -50px auto 0;
	  position: relative;
	  top: 45%;
	  left: 0;
	  min-width: 220px;
	  max-width: 400px;

	  padding: 9px;

	  border: 1px solid hsla(0, 0%, 0%, .5);
	  border-radius: 2px;
	  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);

	  background-color: #474747;

	  color: hsl(0, 0%, 85%);
	  font-size: 16px;
	  line-height: 20px;
	}
	#mozPrintCallback-shim .progress-row {
	  clear: both;
	  padding: 1em 0;
	}
	#mozPrintCallback-shim progress {
	  width: 100%;
	}
	#mozPrintCallback-shim .relative-progress {
	  clear: both;
	  float: right;
	}
	#mozPrintCallback-shim .progress-actions {
	  clear: both;
	}
	  </style>
	  <div class="mozPrintCallback-dialog-box">
		<!-- TODO: Localise the following strings -->
		Preparando documento para imprimir...
		<div class="progress-row">
		  <progress value="0" max="100"></progress>
		  <span class="relative-progress">0%</span>
		</div>
		<div class="progress-actions">
		  <input type="button" value="Cancel" class="mozPrintCallback-cancel">
		</div>
	  </div>
	</div>

  </body>
</html>

