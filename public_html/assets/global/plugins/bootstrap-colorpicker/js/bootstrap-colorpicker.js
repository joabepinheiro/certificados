/* =========================================================
 * bootstrap-colorpicker.js 
 * http://www.eyecon.ro/bootstrap-colorpicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */
 
!function( $ ) {
	
	// Color object
	
	var Color = function(val) {
		this.value = {
			h: 1,
			s: 1,
			b: 1,
			a: 1
		};
		this.setColor(val);
	};
	
	Color.prototype = {
		constructor: Color,
		
		//parse a string to HSB
		setColor: function(val){
			val = val.toLowerCase();
			var that = this;
			$.each( CPGlobal.stringParsers, function( i, parser ) {
				var match = parser.re.exec( val ),
					values = match && parser.parse( match ),
					space = parser.space||'rgba';
				if ( values ) {
					if (space === 'hsla') {
						that.value = CPGlobal.RGBtoHSB.apply(null, CPGlobal.HSLtoRGB.apply(null, values));
					} else {
						that.value = CPGlobal.RGBtoHSB.apply(null, values);
					}
					return false;
				}
			});
		},
		
		setHue: function(h) {
			this.value.h = 1- h;
		},
		
		setSaturation: function(s) {
			this.value.s = s;
		},
		
		setLightness: function(b) {
			this.value.b = 1- b;
		},
		
		setAlpha: function(a) {
			this.value.a = parseInt((1 - a)*100, 10)/100;
		},
		
		// HSBtoRGB from RaphaelJS
		// https://github.com/DmitryBaranovskiy/raphael/
		toRGB: function(h, s, b, a) {
			if (!h) {
				h = this.value.h;
				s = this.value.s;
				b = this.value.b;
			}
			h *= 360;
			var R, G, B, X, C;
			h = (h % 360) / 60;
			C = b * s;
			X = C * (1 - Math.abs(h % 2 - 1));
			R = G = B = b - C;

			h = ~~h;
			R += [C, X, 0, 0, X, C][h];
			G += [X, C, C, X, 0, 0][h];
			B += [0, 0, X, C, C, X][h];
			return {
				r: Math.round(R*255),
				g: Math.round(G*255),
				b: Math.round(B*255),
				a: a||this.value.a
			};
		},
		
		toHex: function(h, s, b, a){
			var rgb = this.toRGB(h, s, b, a);
			return '#'+((1 << 24) | (parseInt(rgb.r) << 16) | (parseInt(rgb.g) << 8) | parseInt(rgb.b)).toString(16).substr(1);
		},
		
		toHSL: function(h, s, b, a){
			if (!h) {
				h = this.value.h;
				s = this.value.s;
				b = this.value.b;
			}
			var H = h,
				L = (2 - s) * b,
				S = s * b;
			if (L > 0 && L <= 1) {
				S /= L;
			} else {
				S /= 2 - L;
			}
			L /= 2;
			if (S > 1) {
				S = 1;
			}
			return {
				h: H,
				s: S,
				l: L,
				a: a||this.value.a
			};
		}
	};
	
	// Picker object
	
	var Colorpicker = function(element, options){
		this.element = $(element);
		var format = options.format||this.element.data('color-format')||'hex';
		this.format = CPGlobal.translateFormats[format];
		this.isInput = this.element.is('input');
		this.component = this.element.is('.color') ? this.element.find('.input-group-btn') : false; // modified by keenthemes for Bootstrap 3.0 support
		
		this.picker = $(CPGlobal.template)
							.appendTo('body')
							.on('mousedown', $.proxy(this.mousedown, this));
		
		if (this.isInput) {
			this.element.on({
				'focus': $.proxy(this.show, this),
				'keyup': $.proxy(this.update, this)
			});
		} else if (this.component){
			this.component.on({
				'click': $.proxy(this.show, this)
			});
		} else {
			this.element.on({
				'click': $.proxy(this.show, this)
			});
		}
		if (format === 'rgba' || format === 'hsla') {
			this.picker.addClass('alpha');
			this.alpha = this.picker.find('.colorpicker-alpha')[0].style;
		}
		
		if (this.component){
			this.picker.find('.colorpicker-color').hide();
			this.preview = this.element.find('i')[0].style;
		} else {
			this.preview = this.picker.find('div:last')[0].style;
		}
		
		this.base = this.picker.find('div:first')[0].style;
		this.update();
	};
	
	Colorpicker.prototype = {
		constructor: Colorpicker,
		
		show: function(e) {
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.place();
			$(window).on('resize', $.proxy(this.place, this));
			if (!this.isInput) {
				if (e) {
					e.stopPropagation();
					e.preventDefault();
				}
			}
			$(document).on({
				'mousedown': $.proxy(this.hide, this)
			});
			this.element.trigger({
				type: 'show',
				color: this.color
			});
		},
		
		update: function(){
			this.color = new Color(this.isInput ? this.element.prop('value') : this.element.data('color'));
			this.picker.find('i')
				.eq(0).css({left: this.color.value.s*100, top: 100 - this.color.value.b*100}).end()
				.eq(1).css('top', 100 * (1 - this.color.value.h)).end()
				.eq(2).css('top', 100 * (1 - this.color.value.a));
			this.previewColor();
		},
		
		setValue: function(newColor) {
			this.color = new Color(newColor);
			this.picker.find('i')
				.eq(0).css({left: this.color.value.s*100, top: 100 - this.color.value.b*100}).end()
				.eq(1).css('top', 100 * (1 - this.color.value.h)).end()
				.eq(2).css('top', 100 * (1 - this.color.value.a));
			this.previewColor();
			this.element.trigger({
				type: 'changeColor',
				color: this.color
			});
		},
		
		hide: function(){
			this.picker.hide();
			$(window).off('resize', this.place);
			if (!this.isInput) {
				$(document).off({
					'mousedown': this.hide
				});
				if (this.component){
					this.element.find('input').prop('value', this.format.call(this));
				}
				this.element.data('color', this.format.call(this));
			} else {
				this.element.prop('value', this.format.call(this));
			}
			this.element.trigger({
				type: 'hide',
				color: this.color
			});
		},
		
		place: function(){
			var offset = this.component ? this.component.offset() : this.element.offset();
			this.picker.css({
				top: offset.top + this.height,
				left: offset.left
			});
		},
		
		//preview color change
		previewColor: function(){
			try {
				this.preview.backgroundColor = this.format.call(this);
			} catch(e) {
				this.preview.backgroundColor = this.color.toHex();
			}
			//set the color for brightness/saturation slider
			this.base.backgroundColor = this.color.toHex(this.color.value.h, 1, 1, 1);
			//se