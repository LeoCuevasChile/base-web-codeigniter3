<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->model('producto_model');

	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
    //----metas Etiquetas ----//
    $config['doctype'] = 'html'; 
    $config['tags'] = array('a'=>'A', 'b'=>'B'); 
    $config['robots'] = array('NOINDEX', 'NOFOLLOW'); 
    $config['keywords'] = array('primero', 'segundo', 'tercero');
    $config['og'] = array(
      'twitter:card'=>'summary',
      'twitter:title'=>'Titulo sitio web',
      'twitter:description'=>'Descripcion sitio web',
      'twitter:url'=>current_url(),
      'twitter:image'=>'rutaimgs/a.jpg',
      'og:locale'=>'es_ES',
      'og:type'=>'website',
      'og:title'=>'Titulo sitio web',
      'og:description'=>'Descripcion sitio web',
      'og:url'=>current_url(),
      'og:site_name'=>'Descripcion sitio web',
      'og:image'=>base_url('assets/img/general/empresa-ii.jpg')
    );
    $data['title'] = 'Titulo sitio web';
    $data['description'] = 'Descripcion sitio web';
    //-----------------//

		$this->meta_tags->initialize($config); 
    
    $data['meta_tags'] = $this->meta_tags->generate_meta_tags();

    $data['view'] = 'inicio';
    $data['datos'] = array($data['title'], $data['meta_tags']);

		$this->load->view('frontend', $data);
  }

  public function productos($a = false, $b = false)
	{
		//----metas Etiquetas ----//
		$config['doctype'] = 'html'; 
		$config['tags'] = array('a'=>'A', 'b'=>'B'); 
		$config['robots'] = array('NOINDEX', 'NOFOLLOW'); 
		$config['keywords'] = array('primero', 'segundo', 'tercero');
		$config['og'] = array(
			'twitter:card'=>'summary',
			'twitter:title'=>'Titulo sitio web',
			'twitter:description'=>'Descripcion sitio web',
			'twitter:url'=>current_url(),
			'twitter:image'=>'rutaimgs/a.jpg',
			'og:locale'=>'es_ES',
			'og:type'=>'website',
			'og:title'=>'Titulo sitio web',
			'og:description'=>'Descripcion sitio web',
			'og:url'=>current_url(),
			'og:site_name'=>'Descripcion sitio web',
			'og:image'=>base_url('assets/img/general/empresa-ii.jpg')
		);
		$data['title'] = 'Titulo sitio web';
		$data['description'] = 'Descripcion sitio web';
		//-----------------//

    $this->meta_tags->initialize($config); 
    
    $data['meta_tags'] = $this->meta_tags->generate_meta_tags();

    $data['datos'] = array($data['title'], $data['meta_tags']);

    if(!$a && !$b){
      $data['view'] = 'productos';
    }elseif(!$b){
      $data['view'] = 'producto-categoria';
    }else{
      $data['view'] = 'producto-detalle';
    }
    
    $this->load->view('frontend', $data);

  }
  
  public function contacto()
	{
		//----metas Etiquetas ----//
		$config['doctype'] = 'html'; 
		$config['tags'] = array('a'=>'A', 'b'=>'B'); 
		$config['robots'] = array('NOINDEX', 'NOFOLLOW'); 
		$config['keywords'] = array('primero', 'segundo', 'tercero');
		$config['og'] = array(
			'twitter:card'=>'summary',
			'twitter:title'=>'Titulo sitio web',
			'twitter:description'=>'Descripcion sitio web',
			'twitter:url'=>current_url(),
			'twitter:image'=>'rutaimgs/a.jpg',
			'og:locale'=>'es_ES',
			'og:type'=>'website',
			'og:title'=>'Titulo sitio web',
			'og:description'=>'Descripcion sitio web',
			'og:url'=>current_url(),
			'og:site_name'=>'Descripcion sitio web',
			'og:image'=>base_url('assets/img/general/empresa-ii.jpg'),
		);
		$data['title'] = 'Titulo sitio web';
		$data['description'] = 'Descripcion sitio web';
		//-----------------//

    $this->meta_tags->initialize($config); 
    
    $data['meta_tags'] = $this->meta_tags->generate_meta_tags();

    $data['view'] = 'contacto';
    $data['datos'] = array($data['title'], $data['meta_tags']);


		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('rut', 'Rut', 'trim|required|min_length[6]|max_length[25]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[40]|callback_valida_email');
		$this->form_validation->set_rules('telefono', 'Teléfono', 'trim|required|min_length[5]|max_length[25]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required|min_length[8]|max_length[3000]');

		if($this->input->method() == 'post'){
			if ($this->form_validation->run() == TRUE){
				$data = array(
					'datos_asunto' => 'Contacto desde sitio web XXXX '.$this->input->post('rut'),
					'datos_nombre' => $this->input->post('nombre'),
					'datos_email' => $this->input->post('email'),
					'datos_rut' => $this->input->post('rut'),
					'datos_telefono' => $this->input->post('telefono'),
					'datos_mensaje' => $this->input->post('mensaje')
				);

				$body = $this->load->view('plantilla/email/email_plantilla', $data, true);

				$result = $this->email
				    ->from('formulario.web@x.cl', 'Contacto desde el Sitio web '.$this->input->post('rut'))
				    ->reply_to($data['datos_email'], $data['datos_nombre'])    // Optional, an account where a human being reads.
				    ->to('contacto@x.cl', 'Empresa')
				    ->bcc('y@x.cl', 'Juan')
				    ->subject($data['datos_asunto'])
				    ->message($body)
				    ->send();
            	
            	$this->session->set_flashdata('item', '
            		<div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
    					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    					<strong>Envío Correcto!</strong> Hemos recibido tus datos y mensaje, pronto un profesional se pondrá en contacto contigo.
					</div>'
				);
     	
        redirect('contacto');

      }else{
        $data['successForm'] = 
            '<div class="alert alert-danger fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <strong>Campos no válidos</strong> Por favor corrige los datos ingresados y presiona enviar nuevamente.
        </div>';
      }
		}

		// inputs del foprmulario de contacto
		$nombre = array(
		        'name'          => 'nombre',
		        'id'            => 'nombre',
		        'placeholder'   => 'Nombre',
		        'value'         => set_value('nombre'),
		        'class'			=> 'form-control',
		        'required'		=> 'required',
		        'maxlength'     => '100'
		);
		$rut = array(
		        'name'          => 'rut',
		        'id'            => 'rut',
		        'placeholder'   => 'Rut/Rut Empresa',
		        'value'         => set_value('rut'),
		        'class'			=> 'form-control',
		        'required'		=> 'required',
		        'maxlength'     => '25'
		);
		$telefono = array(
		        'name'          => 'telefono',
		        'id'            => 'telefono',
		        'placeholder'   => 'Teléfono',
		        'value'         => set_value('telefono'),
		        'class'			=> 'form-control',
		        'required'		=> 'required',
		        'maxlength'     => '50'
		);
		$email = array(
		        'name'          => 'email',
		        'id'            => 'email',
		        'placeholder'   => 'Email',
		        'value'         => set_value('email'),
		        'class'			=> 'form-control',
		        'required'		=> 'required',
		        'maxlength'     => '80'
		);
		$mensaje = array(
		        'name'          => 'mensaje',
		        'id'            => 'mensaje',
		        'placeholder'   => 'Mensaje',
		        'value'         => set_value('mensaje'),
		        'class'			=> 'form-control',
		        'required'		=> 'required',
		        'maxlength'     => '3000',
		        'rows'			=> '3',
		        'cols'			=> '40'
		);

		$input['nombre'] = form_input($nombre);
		$input['rut'] = form_input($rut);
		$input['telefono'] = form_input($telefono);
		$input['email'] = form_input($email);
		$input['mensaje'] = form_textarea($mensaje);
	
		$data['input'] = $input;

    $this->load->view('frontend', $data);



  }
  public function about()
	{
		//----metas Etiquetas ----//
		$config['doctype'] = 'html'; 
		$config['tags'] = array('a'=>'A', 'b'=>'B'); 
		$config['robots'] = array('NOINDEX', 'NOFOLLOW'); 
		$config['keywords'] = array('primero', 'segundo', 'tercero');
		$config['og'] = array(
			'twitter:card'=>'summary',
			'twitter:title'=>'Titulo sitio web',
			'twitter:description'=>'Descripcion sitio web',
			'twitter:url'=>current_url(),
			'twitter:image'=>'rutaimgs/a.jpg',
			'og:locale'=>'es_ES',
			'og:type'=>'website',
			'og:title'=>'Titulo sitio web',
			'og:description'=>'Descripcion sitio web',
			'og:url'=>current_url(),
			'og:site_name'=>'Descripcion sitio web',
			'og:image'=>base_url('assets/img/general/empresa-ii.jpg'),
		);
		$data['title'] = 'Titulo sitio web';
		$data['description'] = 'Descripcion sitio web';
		//-----------------//

		$this->meta_tags->initialize($config); 
    
    $data['meta_tags'] = $this->meta_tags->generate_meta_tags();

    $data['view'] = 'quienes-somos';
    $data['datos'] = array($data['title'], $data['meta_tags']);

		$this->load->view('frontend', $data);
  }
}
