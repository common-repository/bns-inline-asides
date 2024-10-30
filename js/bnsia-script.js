/**
 * BNS Inline Asides JavaScript / jQuery Scripts
 *
 * @package     BNS_Inline_Asides
 * @since       0.9
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2013-2015, Edward Caissie
 *
 * This file is part of BNS Inline Asides plugin
 *
 * Copyright 2013  Edward Caissie  (email : edward.caissie@gmail.com)
 *
 * BNS Inline Asides is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as published
 * by the Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * BNS Inline Asides is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 */

jQuery( document ).ready( function ( $ ) {
	/** Note: $() will work as an alias for jQuery() inside of this function */
	$( document ).ready( function () {
		$( ".aside-toggler" ).click( function () {
			var element = '';
			$( this ).toggleClass( "open" ).toggleClass( "closed" ).next( element + ".aside" ).slideToggle( "slow", function () {
				$( this ).toggleClass( "open" ).toggleClass( "closed" );
			} );
		} );
	} );
} );