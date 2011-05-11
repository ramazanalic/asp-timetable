<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// -------------------------------------------------------------------------------------------------
/**
 * Carabiner
 * Asset Management Library
 * 
 * Carabiner manages javascript and CSS assets.  It will react differently depending on whether
 * it is in a production or development environment.  In a production environment, it will combine, 
 * minify, and cache assets. (As files are changed, new cache files will be generated.) In a 
 * development environment, it will simply include references to the original assets.
 *
 * Carabiner requires the JSMin {@link http://codeigniter.com/forums/viewthread/103039/ released here}
 * and CSSMin {@link http://codeigniter.com/forums/viewthread/103269/ released here} libraries included.
 * You don't need to include them, unless you'll be using them elsewhise.  Carabiner will include them
 * automatically as needed.
 *
 * Notes: Carabiner does not implement GZIP encoding, because I think that the web server should  
 * handle that.  If you need GZIP in an Asset Library, AssetLibPro {@link http://code.google.com/p/assetlib-pro/ }
 * does it.  I've also chosen not to implement any kind of javascript obfuscation (like packer), 
 * because of the client-side decompression overhead. More about this idea from {@link http://ejohn.org/blog/library-loading-speed/ John Resig }.
 * However, that's not to say you can't do it.  You can easily provide a production version of a script
 * that is packed.  However, note that combining a packed script with minified scripts could cause
 * problems.  In that case, you can flag it to be not combined.
 *
 * Carabiner is inspired by PHP Combine {@link http://rakaz.nl/extra/code/combine/ by Niels Leenheer }
 * and AssetLibPro {@link http://code.google.com/p/assetlib-pro/ by Vincent Esche }, among others.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Asset Management
 * @author		Tony Dewan <tonydewan.com>	
 * @version		1.0
 * @license		http://www.opensource.org/licenses/bsd-license.php BSD licensed.
 * @todo		Add grouping of assets (esp. css, for media types)
 */

/*
	===============================================================================================
	 USAGE
	===============================================================================================
	
	Load the library as normal:
	-----------------------------------------------------------------------------------------------
		$this->load->library('carabiner');
	-----------------------------------------------------------------------------------------------
	
	Configure it like so:
	-----------------------------------------------------------------------------------------------
		$carabiner_config = array(
			'script_dir' => 'assets/scripts/', 
			'style_dir'  => 'assets/styles/',
			'cache_dir'  => 'assets/cache/',
			'base_uri'	 => $base,
			'combine'	 => TRUE,
			'dev' 		 => FALSE
		);
		
		$this->carabiner->config($carabiner_config);
	-----------------------------------------------------------------------------------------------
	
	
	There are 8 options. 4 are required:
	
	script_dir
	STRING Path to the script directory.  Relative to the CI front controller (index.php)
	
	style_dir
	STRING Path to the style directory.  Relative to the CI front controller (index.php)
	
	cache_dir
	STRING Path to the cache directory.  Must be writable. Relative to the CI front controller (index.php)
	
	base_uri
	STRING Base uri of the site, like http://www.example.com/
	
	
	4 are not required:
	
	dev
	BOOL Flags whether your in a development environment or not.  See above for what this means.  
	Defaults to FALSE.
	
	combine
	BOOLEAN Flags whether to combine files.  Defaults to TRUE.
	
	minify_js
	BOOLEAN Flags whether to minify javascript. Defaults to TRUE.
	
	minify_css
	BOOLEAN Flags whether to minify CSS. Defaults to TRUE.
	
	
	Add assets like so:
	-----------------------------------------------------------------------------------------------
		$this->carabiner->js('scripts.js');
		
		$this->carabiner->css('reset.css');
		
		$this->carabiner->css('admin/styles.css');
	-----------------------------------------------------------------------------------------------

	
	
	To set a (prebuilt) production version an asset:
	-----------------------------------------------------------------------------------------------
		// pass a second string to the method with a path to the production version
		$this->carabiner->css('wymeditor/wymeditor.js', 'wymeditor/wymeditor.pack.js' );
	-----------------------------------------------------------------------------------------------
	
	
	And to prevent a file from being combined:
	-----------------------------------------------------------------------------------------------
		// pass a boolean FALSE as the third attribute of the method
		$this->carabiner->css('wymeditor/wymeditor.js', 'wymeditor/wymeditor.pack.js', FALSE );
	-----------------------------------------------------------------------------------------------


	
	You can also pass arrays (and arrays of arrays) to these methods. Like so:	
	-----------------------------------------------------------------------------------------------
		// a single array
		$this->carabiner->css( array('base.css', 'base.prod.css') );
		
		// an array of arrays
		$js_assets = array(
			array('dev/jquery.js', 'prod/jquery.js'),
			array('dev/jquery.ext.js', 'prod/jquery.ext.js'),
		)
		
		$this->carabiner->js( $js_assets );
	-----------------------------------------------------------------------------------------------
	
	
	To output your assets, including appropriate markup:
	-----------------------------------------------------------------------------------------------
		// display css
		$this->carabiner->display('css');
		
		//display js
		$this->carabiner->display('js');
	-----------------------------------------------------------------------------------------------
	
	
	Since Carabiner won't delete old cached files, you'll need to clear them out manually.  
	To do so programatically:
	-----------------------------------------------------------------------------------------------
		// clear css cache
		$this->carabiner->empty_cache('css');
		
		//clear js cache
		$this->carabiner->empty_cache('js');
		
		// clear both
		$this->carabiner->empty_cache();
	-----------------------------------------------------------------------------------------------	
	===============================================================================================
*/

class Carabiner {
    
    var $base_uri = '';
    
    var $script_dir  = '';
	var $script_path = '';
	var $script_uri  = '';
	
	var $style_dir  = '';
	var $style_path = '';
	var $style_uri  = '';
	
	var $cache_dir  = '';
	var $cache_path = '';
	var $cache_uri  = '';
	
	var $dev     = FALSE;
	var $combine = TRUE;
	
	var $minify_js  = TRUE;
	var $minify_css = TRUE;
	
	var $js  = array();
	var $css = array();
	
    var $CI;
	
	
	/** 
	* Class Constructor
	*/
	function Carabiner()
	{
		$this->CI =& get_instance();
		log_message('debug', 'Carabiner Asset Management library initialized.');

	}


	/** 
	* Load Config
	* @param	Array of config variables. Requires script_dir, style_dir, cache_dir, and base_uri.
	*			dev, combine, minify_js, minify_css are optional.
	*/	
	public function config($config)
	{
		foreach ($config as $key => $value)
		{
			$this->$key = $value;
		}

		// use the provided values to define the rest of them
		$this->script_path = dirname(BASEPATH).'/'.$this->script_dir;
		$this->script_uri = $this->base_uri.$this->script_dir;
		
		$this->style_path = dirname(BASEPATH).'/'.$this->style_dir;
		$this->style_uri = $this->base_uri.$this->style_dir;

		$this->cache_path = dirname(BASEPATH).'/'.$this->cache_dir;
		$this->cache_uri = $this->base_uri.$this->cache_dir;
	}
	
	
	
	/** 
	* Add JS file to queue
	* @param	String of the path to development version of the JS file.  Could also be an array.
	* @param	String of the path to production version of the JS file. NOT REQUIRED
	* @param	Flag whether the file is to be combined NOT REQUIRED
	*/	
	public function js($dev_file, $prod_file = '', $combine = TRUE)
	{	
		
		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$this->_asset('js', $file[0], $file[1], $file[2]);
				
				}
				
			}else{
				
				$this->_asset('js', $dev_file[0], $dev_file[1], $dev_file[2]);
				
			}
			
		}else{
		
			$this->_asset('js', $dev_file, $prod_file, $combine);
	
		}
	}
	
	
	
	/**
	* Add CSS file to queue
	* @param	String of the path to development version of the CSS file. Could be an array, or array of arrays.
	* @param	String of the path to production version of the CSS file. NOT REQUIRED
	* @param	Flag whether the file is to be combined. NOT REQUIRED
	*/		
	public function css($dev_file, $prod_file = '', $combine = TRUE)
	{

		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$this->_asset('css', $file[0], $file[1], $file[2]);
				
				}
				
			}else{
				
				$this->_asset('css', $dev_file[0], $dev_file[1], $dev_file[2]);
				
			}
			
		}else{
		
			$this->_asset('css', $dev_file, $prod_file, $combine);
	
		}
	}
	
	
	/**
	* Add an asset to queue
	* @param	String of the type of asset (lowercase) . css | js
	* @param	String of the path to development version of the asset.
	* @param	String of the path to production version of the asset. NOT REQUIRED
	* @param	Flag whether the file is to be combined. Defaults to true. NOT REQUIRED
	*/		
	private function _asset($type, $dev_file, $prod_file = '', $combine = TRUE)
	{
		if($prod_file != ''){
			
			$this->{$type}[] = array(
				'dev' => $dev_file,
				'prod' => $prod_file,
				'combine' => $combine
			);
			
		}else{

			$this->{$type}[] = array(
				'dev'=>$dev_file,
				'combine' => $combine
			);
		
		}
	}
	
	
	/** 
	* Display HTML references to the assets
	* @param	Flag the asset type: css|js
	*/		
	public function display($flag)
	{
		switch($flag){
			
			case 'js':
				
				if( empty($this->js) ) return; // if there aren't any js files, just stop!
				
				// if we're in a dev environment
				if($this->dev){
					
					foreach($this->js as $ref):
					
						echo $this->_tag('js', $ref['dev']);
					
					endforeach;
				
				
				// if we're combining files
				} elseif($this->combine) {

					$lastmodified = 0;
					$files = '';
					$not_combined = '';
					
					foreach ($this->js as $ref) {
						
						// get the last modified date of the most recently modified file
						$lastmodified = max( $lastmodified , filemtime( realpath( $this->script_path.$ref['dev'] ) ) );
						$files .= $ref['dev'];

						if($ref['combine'] == false){
							$not_combined .= (isset($ref['prod'])) ? $this->_tag('js', $ref['prod']) : $this->_tag('js', $ref['dev']);							
						}						
					}

					$filename = $lastmodified . md5($files).'.js';
					
					if( file_exists($this->cache_path.$filename) ){
						
						echo $not_combined;
						echo $this->_tag('js', $filename, TRUE);
						
					} else {
						
						echo $this->_combine('js', $filename);
						
					}
				
				// if we're minifying. but not combining
				} elseif(!$this->combine && $this->minify_js) {
					
					// minify each file, cache it, and serve it up. Oy.
					foreach($this->js as $ref):
						
						if( isset($ref['prod']) ){
						
							$f = $this->script_uri . $ref['prod'];
						
						} else {
						
							$f = filemtime( realpath( $this->script_path . $ref['dev'] ) ) . md5($ref['dev']) . '.js';
						
							if( !file_exists($this->cache_path.$f) ){
	
								$c = $this->_minify( 'js', $ref['dev'] );
								$this->_cache($f, $c);
							
							}
							
							$f = $this->cache_uri . $f;
						
						}

						echo $this->_tag('js', $f, TRUE);
				
					endforeach;	
	
				}else{
				
					foreach($this->js as $ref):
					
						$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
						echo $this->_tag('js', $f);
						
					endforeach;
								
				}

			break;

			case 'css':
				
				if( empty($this->css) ) return; // there aren't any css assets, so just stop!
				

				if($this->dev){ // we're in a development evironment
					
					foreach($this->css as $ref):
					
						echo $this->_tag('css', $ref['dev']);
					
					endforeach;
				
				
				} elseif($this->combine) { // we're combining and minifying

					// lets try to cache it, shall we?
					$lastmodified = 0;
					$files = '';
					$not_combined = '';
					
					foreach ($this->css as $ref) {
					
						$lastmodified = max($lastmodified, filemtime( realpath( $this->style_path . $ref['dev'] ) ) );
						$files .= $ref['dev'];
						
						if($ref['combine'] == false){
							$not_combined .= (isset($ref['prod'])) ? $this->_tag('css', $ref['prod']) : $this->_tag('css', $ref['dev']);							
						}						
					}

					$filename = $lastmodified . md5($files).'.css';
					
					if( file_exists($this->cache_path.$filename) ){
						
						echo $not_combined;
						echo $this->_tag('css',  $filename, TRUE);
						
					} else {
					
						echo $this->_combine('css', $filename);
						
					}
				
				
				} elseif(!$this->combine && $this->minify_css) { // we want to minify, but not combine
					
					// minify each file, cache it, and serve it up. Oy.
					foreach($this->css as $ref):
						
						if( isset($ref['prod']) ){
						
							$f = $this->style_uri . $ref['prod'];
						
						} else {
						
							$f = filemtime( realpath( $this->style_path . $ref['dev'] ) ) . md5($ref['dev']) . '.css';
						
							if( !file_exists($this->cache_path.$f) ){
	
								$c = $this->_minify( 'css', $ref['dev'] );
								$this->_cache($f, $c);
							
							}
							
							$f = $this->cache_uri . $f;

						}

						echo $this->_tag('css', $f, TRUE);
				
					endforeach;	
					
				
				}else{ // we're in a production environment, but not minifying or combining

					foreach($this->css as $ref):
						
						$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
						echo $this->_tag('css', $f);
					
					endforeach;					
					
				
				}
				
			break;

		}
	}
	
	
	/** 
	* Internal function for compressing/combining scripts
	* @param	Flag the asset type: css|js
	* @param	Filename of the file-to-be
	*/
	private function _combine($flag, $filename)
	{

		$file_data = '';
		$not_combined = '';
		$filepath = '';
		
		switch($flag){
			
			case 'js':
				
				foreach($this->js as $ref):
					
					if($ref['combine'] == true){
						
						if($this->minify_js){
						
							$file_data .=  $this->_minify( 'js', $ref['dev'] ) . "\n";
						
						}else{
						
							$file_data .=  ( isset($ref['prod']) ) ? file_get_contents($this->script_path . $ref['prod'], 'r')  : file_get_contents($this->script_path . $ref['dev'], 'r');
						
						}
						
					}else{
					
						$not_combined .= ( isset( $ref['prod'] ) ) ? $this->_tag('js',  $ref['prod']) : $this->_tag('js', $ref['dev']);
						
					}
					
				endforeach;			

				
				$this->_cache( $filename, $file_data );
				
				return $not_combined . $this->_tag('js', $filename, TRUE);
				
			break;


			case 'css':
				
				foreach($this->css as $ref):
					
					if($ref['combine'] == true){
						
						if($this->minify_css){
					
							$file_data .=  $this->_minify( 'css', $ref['dev'] ) . "\n";
							
						}else{
						
							$file_data .=  ( isset($ref['prod']) ) ? file_get_contents($this->style_path.$ref['prod'], 'r')."\n"  : file_get_contents($this->style_path.$ref['dev'], 'r') . "\n";
			
						}
						
					}else{
					
						$not_combined .= ($ref['prod'] == '') ? $this->_tag('css', $ref['prod']) : $this->_tag('css', $ref['dev']);
					}
					
				endforeach;			

				$this->_cache( $filename, $file_data );
				
				return $not_combined . $this->_tag('css', $filename, TRUE);
				
			break;
			
		}
	
	}


	/** 
	* Internal function for minifying assets
	* @param	Flag the asset type: css|js
	* @param	Contents to be minified
	*/
	private function _minify($flag, $file_ref)
	{
	
		switch($flag){
			
			case 'js':
			
				$this->CI->load->library('jsmin');
				
				$contents = file_get_contents($this->script_path.$file_ref, 'r');
				return $this->CI->jsmin->minify($contents);
			
			break;
			
			
			case 'css':
			
				$this->CI->load->library('cssmin');
				$this->CI->cssmin->config(array('relativePath'=>$this->style_uri));
				
				$contents = file_get_contents($this->style_path.$file_ref, 'r');
				return $this->CI->cssmin->minify($contents);
			
			break;
		}
	
	}
	
	
	/** 
	* Internal function for writing cache files
	* @param	filename of the new file
	* @param	Contents of the new file
	*/
	private function _cache($filename, $file_data)
	{

		$filepath = $this->cache_path . $filename;
		file_put_contents( $filepath, $file_data );			
	
	}
	
	/** 
	* Internal function for making tag strings
	* @param	flag for type: css|js
	* @param	Contents of the new file
	* @param	Flag for cache dir
	*/
	private function _tag($flag, $ref, $cache = FALSE)
	{
	

		switch($flag){
		
			case 'css':
				
				$dir = ($cache) ? $this->cache_uri : $this->style_uri;
				
				echo '<link type="text/css" rel="stylesheet" href="'.$dir.$ref.'">'."\r\n";
			
			break;

			case 'js':
				
				$dir = ($cache) ? $this->cache_uri : $this->script_uri;
				
				echo '<script type="text/javascript" src="'.$dir.$ref.'"></script>'."\r\n";
			
			break;
		
		}
	
	}	
	
	/** 
	* Function used to clear the asset cache. If no flag is set, both CSS and JS will be emptied.
	* @param	Flag the asset type: css|js|both
	*/		
	public function empty_cache($flag)
	{
		
		$this->CI->load->helper('file');
		
		$files = get_filenames($this->cache_path);

		switch($flag){

			case 'js':
			case 'css':
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					
					if ( $ext == $flag ) {

						unlink( $this->cache_path . $file );

					}
					
				}
			
			break;
			
			
			default:
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					
					if ( $ext == 'js' || $ext == 'css') {

						unlink( $this->cache_path . $file );

					}
					
				}	
				
			break;
		
		}			
	
	}
}