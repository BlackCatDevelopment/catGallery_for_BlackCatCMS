{**
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Dirk Grebe
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}
 
<div class="modal fade" id="bs_modal_{$image.image_id}" tabindex="-1" {if $options.mbackdrop}data-backdrop="static"{/if} aria-labelledby="{$image.options.title}" aria-hidden="true">
	<div class="modal-dialog {$options.msize} {if $options.mpos}modal-dialog-centered{/if}">
		<div class="modal-content">
<!-- Modal header begin -->
			<div class="modal-header">
				{if $options.ititle}<h5>{$image.options.title}</h5>{/if}
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
			</div>
<!-- Modal content begin -->
			<div class="modal-body">  
				<img class="img-fluid" src="{$image.original}" alt="{$image.options.alt}" />
				{if $options.icontent}<p class="text-center">{$image.image_content}</p>{/if}
			</div>
<!-- Modal footer begin -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>
			</div>
		</div>
	</div>
</div>