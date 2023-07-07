<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileFormRequest;
use App\Models\User;
use App\Models\Perfil;
use DB;

class UserControl extends Controller
{
	public function lista(User $user)
	    { 
    		
          $users = User::all()->reverse();


          	return view('admin.cadastro.lista', compact('users'));
          }
    public function perfil(User $user)
      { 
            
          $users = User::all()->reverse();
    
    
            return view('admin.cadastro.perfil', compact('users'));
          }
    public function usuario(User $user, Request $request)
	    { 
	    	$cid = $request->cid;
	    	
	    	$users = User::find($cid);
            $perfils = Perfil::where('user_id', $cid)->get()->first();
            

            if (is_null($perfils)) {
                $perfils = new perfil;
                $perfils->user_id = $cid;
                $perfils->perfil = 'S';
                $perfils->save();
            }
            //dd($perfils->perfil);
          	return view('admin.cadastro.usuario', compact('users', 'cid', 'perfils' ))->with('success', 'Novo Usuário');
          }
          public function editperfil(User $user, Request $request, Perfil $perfils)
	    { 
	    	$cid = $request->cid;
	    
        $users = User::find($cid);
        
        $perfils = Perfil::All();
            
          	return view('admin.cadastro.editperfil', compact('users', 'cid', 'perfils' ));
          }
          public function muda_perfil(User $user, Request $request, Perfil $perfils)
          { 
            $pid = $request->pid;
            $cid = $request->cid;

            $users = User::all()->reverse();
          
            $perfils = Perfil::find($pid);
            
                return view('admin.cadastro.muda_perfil', compact('pid', 'perfils', 'cid'));
              }
          public function m_perfil(User $user, Request $request, Perfil $perfils)
              { 
                $pid = $request->pid;

                $users = User::all()->reverse();
              
                $data = Perfil::find($pid);

                //$data = Perfil::where('user_id', $dataForm->id)->get()->first();
            
                $data->perfil = $request->userperfil;
                $data->update();
               
                return view('admin.cadastro.perfil', compact('users'));
              }
          public function n_perfil(User $user, Request $request, Perfil $perfils)
              { 

                $users = User::all()->reverse();
                $cid = $request->cid;
                
                $perfils = new perfil;
                $perfils->user_id = $cid;
                $perfils->perfil = 'S';
                $perfils->save();
               
                return view('admin.cadastro.perfil', compact('users'));
              }
          public function del_perfil(User $user, Request $request, Perfil $perfils)
              { 
                $pid = $request->pid;

                $users = User::all()->reverse();
              
                $perfils = Perfil::find($pid);

                $perfils->delete();
               
                return view('admin.cadastro.perfil', compact('users'));
              }
    public function store(User $user, Request $request, Perfil $perfil)
    {
    		
            $dataForm = User::where('cpf', $request->cpf)->get()->first();
            
            $dataForm->name = $request->nome;
            $dataForm->email = $request->email;
            $dataForm->cns = $request->cns;
            $dataForm->nacionalidade = $request->nacionalidade;
            $dataForm->data_nascimento = $request->data_nascimento;
            $dataForm->sexo = $request->sexo;
            $dataForm->cnes = $request->cnes;
            $dataForm->telefone_residencial = $request->telefone_residencial;
            $dataForm->telefone_celular = $request->telefone_celular;
            $dataForm->conselho = $request->conselho;
            $dataForm->num_conselho = $request->num_conselho;
            $dataForm->razao_social = $request->razao_social;
            $dataForm->nome_fantasia = $request->nome_fantasia;
            $dataForm->ocupacao = $request->ocupacao;
            $dataForm->especialidade = $request->especialidade;
            $dataForm->nome_cargo = $request->nome_cargo;
            $dataForm->fonte = $request->userfonte;
        	$dataForm->update();

            $data = Perfil::where('user_id', $dataForm->id)->get()->first();
            
            $data->perfil = $request->userperfil;
            $data->update();

              return redirect()
                    ->route('admin.cadastro.lista')
                    ->with('success', 'Cadastro Alterado');
    }
    public function deletar(Request $request)
    {
    		$cid = $request->cid;

    		if ($cid!='1') {
    			# code...
    		
            $user = user::find($cid);

            $user->delete();

              return redirect()
                    ->route('admin.cadastro.lista')
                    ->with('success', 'Usuário Deletado');
            }
            else{
            	return redirect()
                    ->route('admin.cadastro.lista')
                    ->with('error', 'Este Usuário é administrador e não pode ser Deletado');
            }
    }
    public function profile()
    {
    	return view('site.profile.profile');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {
		$user = auth()->user();

    	$data = $request->all();

	if ($data['password'] != null)
		$data['password'] = bcrypt($data['password']);
	else
		unset($data['password']);

	$data['image'] = $user->image;

	if ($request->hasFile('image') && $request->file('image')->isValid()) {
		if ($user->image)
			$name = $user->image;
		else
			$name = $user->id.kebab_case($user->name);

		$extenstion = $request->image->extension();
		$nameFile = "{$name}.{$extenstion}";

		$data['image'] = $nameFile;

		$upload = $request->image->storeAs('users', $nameFile);
		
		if (!$upload)
			return redirect()
						->back()
						->with('error', 'Falha ao fazer o upload da imagem');

	}

	$update = auth()->user()->update($data);

	if($update)
		return redirect()
					->route('profile')
					->with('success', 'Sucesso ao atualizar!');
		return redirect()
					->back()
					->with('error', 'Falha ao atualizar o perfil...');

    }
}
