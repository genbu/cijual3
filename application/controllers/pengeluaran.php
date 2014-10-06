<?php
class pengeluaran extends CI_Controller{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login_status') != TRUE ){
            $this->session->set_flashdata('notif','LOGIN GAGAL USERNAME ATAU PASSWORD ANDA SALAH !');
            redirect('');
        };
        $this->load->model('model_app');
        $this->load->helper('currency_format_helper');
    }

    function index(){
        $data=array(
            'title'=>'pengeluaran Barang',
            'active_pengeluaran'=>'active',
            'data_pengeluaran'=>$this->model_app->getAllDatapengeluaran(),
        );
        $this->load->view('element/v_header',$data);
        $this->load->view('pages/v_pengeluaran');
        $this->load->view('element/v_footer');

        $this->session->unset_userdata('limit_add_cart');
        $this->cart->destroy();
    }

//    GET DATA
    function pages_tambah_pengeluaran(){
        $data=array(
            'title'=>'Tambah pengeluaran Barang',
            'active_pengeluaran'=>'active',
            'kd_pengeluaran'=>$this->model_app->getKodepengeluaran(),
            'data_barang'=>$this->model_app->getBarangJual(),
            'data_pelanggan'=>$this->model_app->getAllData('tbl_pelanggan'),
        );
        $this->load->view('element/v_header',$data);
        $this->load->view('pages/v_add_pengeluaran');
        $this->load->view('element/v_footer');
    }

    function detail_pengeluaran(){
        $id= $this->uri->segment(3);
        $data=array(
            'title'=>'Detail pengeluaran Barang',
            'active_pengeluaran'=>'active',
            'dt_pengeluaran'=>$this->model_app->getDatapengeluaran($id),
            'barang_jual'=>$this->model_app->getBarangpengeluaran($id),
        );
        $this->load->view('element/v_header',$data);
        $this->load->view('pages/v_detail_pengeluaran');
        $this->load->view('element/v_footer');
    }

    function get_detail_barang(){
        $id['kd_barang']=$this->input->post('kd_barang');
        $data=array(
            'detail_barang'=>$this->model_app->getSelectedData('tbl_barang',$id)->result(),
        );
        $this->load->view('pages/ajax_detail_barang',$data);
    }

    function get_detail_pelanggan(){
        $id['kd_pelanggan']=$this->input->post('kd_pelanggan');
        $data=array(
            'detail_pelanggan'=>$this->model_app->getSelectedData('tbl_pelanggan',$id)->result(),
        );
        $this->load->view('pages/ajax_detail_pelanggan',$data);
    }

//    INSERT DATA
    function tambah_pengeluaran_to_cart(){
        $data = array(
            'id'    => $this->input->post('kd_barang'),
            'qty'   => $this->input->post('qty'),
            'price' => $this->input->post('harga'),
            'name'  => $this->input->post('nm_barang'),
        );
        $this->cart->insert($data);
        redirect('pengeluaran/pages_tambah_pengeluaran');
    }

    function simpan_pengeluaran(){
        $data = array(
            'kd_pengeluaran'=>$this->input->post('kd_pengeluaran'),
            'kd_pelanggan'=>$this->input->post('kd_pelanggan'),
            'total_harga'=>$this->input->post('total_harga'),
            'tanggal_pengeluaran'=>date("Y-m-d",strtotime($this->input->post('tanggal_pengeluaran'))),
            'kd_pegawai'=>$this->session->userdata('ID'),
        );
        $this->model_app->insertData("tbl_pengeluaran_header",$data);

        foreach($this->cart->contents() as $items){
            $kd_barang = $items['id'];
            $qty = $items['qty'];
            $data_detail = array(
                'kd_pengeluaran' => $this->input->post('kd_pengeluaran'),
                'kd_barang'=> $kd_barang,
                'qty'=>$qty,
            );
            $this->model_app->insertData("tbl_pengeluaran_detail",$data_detail);

            $update['stok'] = $this->model_app->getKurangStok($kd_barang,$qty);
            $key['kd_barang'] = $kd_barang;
            $this->model_app->updateData("tbl_barang",$update,$key);
        }
        $this->session->unset_userdata('limit_add_cart');
        $this->cart->destroy();
        redirect('pengeluaran');
    }


//    DELETE
    function hapus_barang(){
        $id= $this->uri->segment(3);
        $bc=$this->model_app->getSelectedData("tbl_pengeluaran_header",$id);
        foreach($bc->result() as $dph){
            $sess_data['kd_pengeluaran'] = $dph->kd_pengeluaran;
            $this->session->set_userdata($sess_data);
        }

        $kode = explode("/",$_GET['kode']);
        if($kode[0]=="tambah")
        {
            $data = array(
                'rowid' => $kode[1],
                'qty'   => 0
            );
            $this->cart->update($data);
        }
        else if($kode[0]=="edit")
        {
            $data = array(
                'rowid' => $kode[1],
                'qty'   => 0
            );
            $this->cart->update($data);
            $hps['kd_pengeluaran'] = $kode[2];
            $hps['kd_barang'] = $kode[3];
            $this->model_app->deleteData("tbl_pengeluaran_detail",$hps);

            $key_barang['kd_barang'] = $hps['kd_barang'];
            $d_u['stok'] = $kode[4]+$kode[5];
            $this->model_app->updateData("tbl_barang",$d_u,$key_barang);
        }
        redirect('pengeluaran/pages_edit/'.$this->session->userdata('kd_pengeluaran'));
    }

    function hapus(){
        $hapus['kd_pengeluaran'] = $this->uri->segment(3);
        $q = $this->model_app->getSelectedData("tbl_pengeluaran_detail",$hapus);
        foreach($q->result() as $d){
            $d_u['stok'] = $this->model_app->getTambahStok($d->kd_barang,$d->qty);
            $key['kd_barang'] = $d->kd_barang;
            $this->model_app->updateData("tbl_barang",$d_u,$key);
        }
        $this->model_app->deleteData("tbl_pengeluaran_header",$hapus);
        $this->model_app->deleteData("tbl_pengeluaran_detail",$hapus);
        redirect('pengeluaran');
    }
}
