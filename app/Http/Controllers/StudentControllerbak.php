<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ipt;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use PDF;

class StudentController extends Controller
{
    //
    public function index(Request $request)
    {
        $ipt_id = $request->get('ipt_id');
        $email = $request->get('email');

        if (!empty($email) && !empty($ipt_id)) {            
            Session::put('ipt_id', $ipt_id);
            Session::put('email', $email);

            $ipt_id = Session::get('ipt_id');
            $email = Session::get('email');

            
            $users = User::whereNotNull('ipt_id') 
            ->where('ipt_id', '=', $ipt_id)
            ->where('email', '=', $email) 
            ->paginate(10);              

         }elseif (!empty($email)) {
             Session::put('email', $email);             
             $email = Session::get('email');

           
                $users = User::where('email', 'LIKE', '%'.$email.'%')
                ->paginate(10); 
         } else {
            
                $users = User::paginate(10);
         }

        // $ipts = Ipt::orderBy('ipt', 'asc')->get();
      // dd($users);
        return view('student.index',compact('users','ipt_id','email'));
    }

    public function editForm($id)
    {
        $users = User::find($id);
        $act='edit';
        
        return view('student.form',compact( 'users','act'));
    }

    public function edit(Request $request)
    {
            $staff_no = $request->get('staff_no');
            $id = $request->get('id');
            $user = User::find($id);
            $user->name = $request->get('name');
            $user->no_kp = $request->get('no_kp'); 
            //$user->angka_giliran = $angka_giliran; 
            $user->save();
           // dd($user);

        return redirect()->route('student.index')->with('success', 'Berjaya dikemaskini');;
    }


    public function form()
    {
        
        $act='';
        return view('student.form',compact('act'));
    }

    protected function create(Request $request, User $user)
    {
        $request->validate([
            'no_kp'=>'required|unique:users,email', 
			'angka_giliran'=>'required', 
        ]);
        //dd($request->get('ipt_id'));
        $no_kp = $request->get('no_kp');
         $angka_giliran = $request->get('angka_giliran');

        $user = new User([
            'name' => $request->get('name'), 
            'no_kp' => $no_kp,
            'email' => $no_kp, 
            'password' => Hash::make($angka_giliran),
        ]);
        $user->save();

        return redirect('/student')->with('success', 'Saved!');
    }

    public function destroy($id)
    {
        
        $user = User::findOrFail($id);
         
        $user->delete();

        Session::flash('success', 'Berjaya dipadam!');

        //return redirect()->route('student.index');
        return redirect('/student')->with('success', 'Berjaya disimpan !');
        
    }

    public function user_answer($id)
    {
        $users = User::find($id);
        $userAnswers = userAnswer::where('user_id',$id) 
        ->join('questions','questions.id','=','user_answers.question_id')
        ->orderby('questions.question_type_id','ASC')
        ->paginate(50);   
       
        return view('student.user_answer',compact('userAnswers','users'));
    }

    public function pdf($id)
    {
        $users = User::find($id);
     
        PDF::SetTitle('MySTAFF');
        // set font
        

//     PDF::SetMargins(10, 0, 10, true); // set the margins

// set margins
/*
PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
PDF::SetFooterMargin(PDF_MARGIN_FOOTER);
*/

// set margins
//PDF::SetMargins(0, PDF_MARGIN_TOP, 0);

// set auto page breaks
//PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
// set default header data
//PDF::SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, ' 005', PDF_HEADER_STRING);

 
        PDF::AddPage();

// set cell padding
//PDF::setCellPaddings(1, 1, 1, 1);

// set cell margins
//PDF::setCellMargins(0, -10, 1, 1);

// set color for background
PDF::SetFillColor(255, 255, 127);


        $txt = ''.$users->staff_no.'';



// set margins
PDF::SetMargins(10, PDF_MARGIN_TOP, 10);

// set auto page breaks
PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);


//PDF::AddPage('P', 'A4');
//PDF::Cell(0, 0, 'A4 PORTRAIT', 1, 1, 'C');


        // print a block of text using Write()
        PDF::SetFont('helvetica', 'B',25 );
	PDF::MultiCell(0, 0, $txt, 0, 'R', 0, 0, '', '', true, 0, false, true, 40, 'T');

//        PDF::Write(0, $txt, '', 0, 'R', true, 0, false, false, 0);

        //$barcode = '<img src="{{public/images/.($employee -> image)}}" width="50px">';
        //$barcode = '<img src="{{ asset("storage/images/sample.jpg") }}" width="50px">';
        //$barcode = {{ asset("storage/images/sample.jpg") }}";
        $url = 'https://myrela.moha.gov.my/mystaf/public/images/'.$users->no_kp.'.jpg';
        //PDF::Write(0, $url, '', 0, 'R', true, 0, false, false, 0);
        //PDF::writeHTML($barcode, '', 5, 100, 80, '', '', 'M');
         //PDF::Image($url, '80', 80, '', '70', 'jpg', '', '', false, 100, '', false, false, 0, false, false, false);
       //  'kiri/kanan', 'atas/bawah',' ', ''
       PDF::Image($url,'66', 80, '', '115', 'jpg', '', '', 'false', 90, '', false, false, 0, false, false, false);
       //PDF::Image($url, '', 0, 'R', true, 0, false, false, 0);

       PDF::Ln(200);//makin banyak value objek turun ke bawah
	//PDF::MultiCell(50, 0, $users->name, 0, 'C', 0, 0, '', '', true);
        $txt2 =''.$users->name.' 
        ';
         
        PDF::SetFont('helvetica', 'B', 42);
	PDF::MultiCell(0, 0, $users->name, 0, 'C', 'C');



//	PDF::SetMargins(10, 10, 10, true);
        // print a block of text using Write()
        //PDF::Write(0, $txt2, '', 0, 'C', true, 0, false, false, 0);
	//PDF::MultiCell(180, 100, $users->name, 0, 'C', 0, 0, '', '', false);
//	PDF::MultiCell(150, 0, $users->name., 0, 'C', 0, 0, '', '', true);
// set color for background
PDF::SetFillColor(255, 255, 127);
//PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - TOP] '.$users->name, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T');
//PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - MIDDLE] '.$users->name, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'M');
//PDF::MultiCell(55, 40, '[VERTICAL ALIGNMENT - BOTTOM] '.$users->name, 1, 'J', 1, 1, '', '', true, 0, false, true, 40, 'B');





        PDF::Ln(0);
       // $txt3 =''.$users->no_kp.'';
        
        //PDF::SetFont('helvetica', 'B', 40);

        // print a block of text using Write()
        //PDF::Write(0, $txt3, '', 0, 'C', true, 0, false, false, 0);
   	//PDF::MultiCell(150,100 , $users->no_kp, 0, 'C', 0, 200, '', '', false);
        
	PDF::SetFont('helvetica', 'B', 40);
        PDF::MultiCell(0, 0, $users->no_kp, 0, 'C', 'C');

	// output the HTML content
	//PDF::writeHTML($html, true, false, true, false, '');

        

        PDF::Output('hello_world.pdf');
        
    }


}
