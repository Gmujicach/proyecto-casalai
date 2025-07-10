$(document).ready(function(){
    // Anular ingreso/egreso
    $(".anular-finanza").on("click", function(){
        let id = $(this).data("id");
        Swal.fire({
            title: '¿Anular?',
            text: "No podrás revertir esto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, anular'
        }).then((result) => {
            if(result.isConfirmed){
                $.post('controlador/finanza.php', {accion:'anular', id_finanzas:id}, function(resp){
                    let r = JSON.parse(resp);
                    if(r.status === 'success'){
                        Swal.fire('Anulado','Registro anulado','success').then(()=>location.reload());
                    }else{
                        Swal.fire('Error','No se pudo anular','error');
                    }
                });
            }
        });
    });
});