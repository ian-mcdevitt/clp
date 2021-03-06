<?php
	/*
	This file is part of CLPPhotoSite.

	CLPPhotoSite is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	CLPPhotoSite is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with CLPPhotoSite.  If not, see <http://www.gnu.org/licenses/>.
	*/ 

	include('includes/includes.php');
	include("top.php");
	$_GET['g'] = mysql_real_escape_string($_GET['g']);
	if(isset($_GET['g']) && strlen($_GET['g']) > 0 && in_array($_GET['g'], array('home','families','glamour','weddings','events','personal')))
	{
		$disclaimer_height = 600;
		
		$res = mysql_query("SELECT gallery_num FROM galleries WHERE gallery_num = '" . $_GET['g'] . "' OR gallery_id = '" . $_GET['g'] . "'");
		$row = ($res !== false ? mysql_fetch_assoc($res) : false);
		if($row !== false && file_exists('galleries/' . $row['gallery_num']))
		{
			$gallery_num = $row['gallery_num'];
			$dir_handle = opendir('galleries/' . $gallery_num);
			if($dir_handle !== false)
			{
				$slideshow = true;
				$filename_string = '';
				while($filename = readdir($dir_handle))
				{
					if($filename != '.' && $filename != '..')
					{
						$filename_string .= '["galleries/' . $gallery_num . '/' . $filename . '"],';
					}
				}
				$filename_string = substr($filename_string, 0, -1);
			?>
				<script type="text/javascript" src="includes/fadeslideshow.js">
				/***********************************************
				* Ultimate Fade In Slideshow v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
				* This notice MUST stay intact for legal use
				* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
				***********************************************/
				</script>
				<script>
				var mygallery=new fadeSlideShow({
					wrapperid: "slideshow",
					dimensions: [780, 520],
					imagearray: [<?php echo $filename_string; ?>],
					displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false},
					persist: false,
					fadeduration: 500,
					descreveal: "none",
					togglerid: ""
				})
				</script>
			<?php
			}
		}
	}
	else if(isset($_GET['g']) && strlen($_GET['g']) > 0)
	{
		$res = mysql_query("SELECT * FROM galleries WHERE gallery_num = '" . $_GET['g'] . "' OR gallery_id = '" . $_GET['g'] . "'");
		$row = ($res !== false ? mysql_fetch_assoc($res) : false);
		if($row !== false && file_exists('galleries/' . $row['gallery_num']))
		{
			$gallery_num = $row['gallery_num'];
			$ids = '';
			$dir_handle = opendir('galleries/' . $gallery_num);
			while (($file = readdir($dir_handle)) !== false)
			{
				if(!in_array($file, array('.', '..')) && !is_dir('../galleries/' . $gallery_num . '/' . $file)) 
				{
					$ids .= "'" . $file . "',";
				}
			}
			$ids = substr($ids, 0, -1);
			if(strlen($ids) > 1)
			{
				$slideshow = true;
			?>
				<span style="height:520px; background-color:#FF0000; width:0px; display:inline-block; vertical-align:middle; float:left;"></span>
				<link rel="stylesheet" type="text/css" media="screen" href="includes/photoslider.css" />
				<script type="text/javascript" src="includes/photoslider.js"></script>
				<center>
				<script type="text/javascript">
				
				$(document).ready(function()
				{
					var ids = new Array(<?php echo $ids; ?>);
					FOTO.Slider.gallery_name = '<?php echo addslashes($row['gallery_name']); ?>';
					FOTO.Slider.gallery_date = '<?php echo addslashes($row['event_date']); ?>';
					FOTO.Slider.baseURL = 'galleries/<?php echo $gallery_num; ?>/';
					FOTO.Slider.importBucketFromIds('slideshow',ids);  
					FOTO.Slider.reload('slideshow');  
					FOTO.Slider.preloadImages('slideshow');
					FOTO.Slider.enableSlideshow('slideshow');
					FOTO.Slider.play('slideshow');
				});  
				</script>
				</center>
			<?php
			}
		}
	}
	
	if(!isset($slideshow) || $slideshow == false)
	{
		$disclaimer_height = 600;
		?>
		<table style="height:100%; width:100%; background: url('images/static.jpg');">
			<tr>
				<td width="25%"></td>
				<td align="center" valign="middle" style="color:#FFFFFF; font-family: Verdana, Arial, Sans-Serif; font-size:20px;">
					Gallery Not Found.<br>Please check your Gallery ID.
					<br>
					Please allow 48 hours for photos to be uploaded.
				</td>
				<td width="25%"></td>
			</tr>
		</table>
		<?php
	}

	include("bottom.php");
?>