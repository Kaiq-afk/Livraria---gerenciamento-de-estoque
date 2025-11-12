// public/js/app.js
function confirmDelete(){
  return confirm('Tem certeza que deseja excluir este livro?');
}
function validateForm(form){
  var t = form.titulo.value.trim(), a = form.autor.value.trim(), g = form.genero.value.trim();
  if(!t || !a || !g){ alert('Preencha título, autor e gênero.'); return false; }
  return true;
}
