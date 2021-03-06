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
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
	*/ 

	include('includes.php');
	$title = "Admin Home";
	include('top.php');
?>
	<table style="width:60%; min-width:1000px;">
		<tr class="dataTableHeadingRow">
			<th class="dataTableHeadingContent">Gallery Number</th>
			<th class="dataTableHeadingContent">Gallery ID</th>
			<th class="dataTableHeadingContent">Gallery Name</th>
			<th class="dataTableHeadingContent">Event Date</th>
			<th class="dataTableHeadingContent">Controls</th>
		</tr>
		<?php
			$res = mysql_query('SELECT * FROM galleries ORDER BY create_date ASC');
			while($row = mysql_fetch_assoc($res))
			{
				foreach($row as $key => $value)
				{
					$row[$key] = stripslashes($value);
				}
				echo '
				<tr class="dataTableRow">
					<td class="dataTableContent" width="120">
						' . (strlen($row['gallery_num']) > 0 ? $row['gallery_num'] : '&nbsp;') . '
					</td>
					<td class="dataTableContent" width="120">
						' . (strlen($row['gallery_id']) > 0 ? $row['gallery_id'] : '&nbsp;') . '
					</td>
					<td class="dataTableContent">
						' . (strlen($row['gallery_name']) > 0 ? $row['gallery_name'] : '&nbsp;') . '
					</td>
					<td class="dataTableContent" width="120">
						' . (strlen($row['event_date']) > 0 ? $row['event_date'] : '&nbsp;') . '
					</td>
					<td class="dataTableContent" width="130">
						<a href="../gallery.php?g=' . $row['gallery_num'] . '" target="_blank">View</a> | 
						<a href="edit_gallery.php?g='. $row['gallery_num'] . '">Edit</a>';
				if(is_numeric($row['gallery_num']))
				{
					echo ' | <a href="delete_gallery.php?g=' . $row['gallery_num'] . '" onclick="return confirm(\'Are you sure you want to delete Gallery ' . $row['gallery_num'] . '?\');">Delete</a>';
				}
				echo '</tr>';
			}
			if(mysql_num_rows($res) == 0)
			{
				echo '<tr class="dataTableRow"><td colspan="5" class="dataTableContent">No Galleries Exist. <a href="create_gallery.php">Create one?</a></td></tr>';
			}
		?>
	</table>
<?php include('bottom.php'); ?>