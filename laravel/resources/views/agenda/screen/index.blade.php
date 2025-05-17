@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="center-align" style="margin-bottom: 30px;">📅 Minha Agenda</h4>

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <!-- Input de data -->
    <div class="row">
        <div class="input-field col s12 m6 offset-m3">
            <input type="text" id="data_escolhida" class="datepicker">
            <label for="data_escolhida">Ir para uma data específica</label>
        </div>
    </div>

    <!-- Calendário com estilo moderno -->
    <div class="card z-depth-2" style="padding: 20px; border-radius: 12px;">
        <div id="calendar" style="max-width: 100%; margin: auto;"></div>
    </div>
</div>

<!-- Modal para detalhes do evento -->
<div id="detalheEvento" class="modal grey lighten-4 z-depth-3" style="border-radius: 12px; max-width: 600px;">
  <div class="modal-content" style="padding: 24px;">
    <h5 class="grey-text text-darken-2" style="margin-bottom: 24px;">📌 Detalhes da Reunião</h5>

    <!-- Formulário para editar os dados -->
    <form id="formEvento" method="POST" action="{{ route('agenda.event.store', ['id' => '']) }}">
      @csrf
      @method('POST')
      
      <div class="input-field">
        <label for="evt-tipo" class="active">Tipo:</label>
        <select id="evt-tipo" name="tipo" class="validate" required>
          <option value="" disabled selected>Escolha um tipo</option>
          @foreach($tipos as $tipo)
            <option value="{{ $tipo->id }}">
              {{ $tipo->nome }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="input-field">
        <label for="evt-status" class="active">Status:</label>
        <select id="evt-status" name="status" class="validate" required>
          <option value="" disabled selected>Escolha um Status</option>
          @foreach($status as $statu)
            <option value="{{ $statu->id }}">
              {{ $statu->nome }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="input-field">
        <label for="evt-inicio" class="active">Início:</label>
        <input type="datetime-local" id="evt-inicio" name="inicio" class="validate" required>
      </div>

      <div class="input-field">
        <label for="evt-fim" class="active">Fim:</label>
        <input type="datetime-local" id="evt-fim" name="fim" class="validate" required>
      </div>

      <div class="input-field">
        <label for="evt-resp" class="active">Responsável:</label>
        <select id="evt-resp" name="responsavel" class="validate" required>
          <option value="" disabled selected>Escolha um Responsável</option>
          @foreach($responsaveis as $responsavel)
            <option value="{{ $responsavel->id }}">
              {{ $responsavel->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="input-field">
        <label for="evt-clie" class="active">Cliente:</label>
        <select id="evt-clie" name="cliente" class="validate" required>
          @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}" 
              data-telefone="{{ $cliente->telefone }}" 
              data-email="{{ $cliente->email }}">
              {{ $cliente->nome }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="input-field">
        <label for="evt-tel" class="active">Telefone:</label>
        <input type="tel" id="evt-tel" name="telefone" class="validate" required readonly>
      </div>

      <div class="input-field">
        <label for="evt-email" class="active">Email:</label>
        <input type="email" id="evt-email" name="email" class="validate" required readonly>
      </div>
    </form>
  </div>

  <!-- Rodapé com botões -->
  <div class="modal-footer grey lighten-3" style="border-top: 1px solid #ddd; border-radius: 0 0 12px 12px;">
  <a href="#!" class="modal-close btn grey darken-2 white-text waves-effect waves-light" style="border-radius: 8px;">Fechar</a>
    <button type="submit" form="formEvento" class="btn grey darken-2 white-text waves-effect waves-light" style="border-radius: 8px;">Salvar</button>
  </div>
</div>

<!-- Custom style para visual moderno -->
<style>
    #calendar { margin-top: 20px; }
    .fc { font-family: "Roboto", sans-serif; color: #333; }
    .fc-toolbar-title { font-size: 1.5rem; font-weight: 500; }
    .fc-button {
        background-color: #1976d2;
        border: none; border-radius: 6px;
        padding: 6px 12px;
    }
    .fc-button-primary:not(:disabled).fc-button-active,
    .fc-button-primary:not(:disabled):active,
    .fc-button:hover {
        background-color: #1976d2;
    }
    .fc-daygrid-event {
        background-color: #1976d2;
        border: none; padding: 2px 4px;
        border-radius: 4px; font-size: 0.85rem;
    }
</style>

<script>
    function formatDateToInput(date) {
        const pad = n => n.toString().padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    document.getElementById('evt-clie').addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];

      const telefone = selectedOption.getAttribute('data-telefone');
      const email = selectedOption.getAttribute('data-email');

      document.getElementById('evt-tel').value = telefone || '';
      document.getElementById('evt-email').value = email || '';
    });

document.addEventListener('DOMContentLoaded', function () {
    // Inicializa modal
    var modalElems = document.querySelectorAll('.modal');
    M.Modal.init(modalElems);

    // Inicializa o calendário
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ url("agendas/eventos") }}',
        eventClick: function(info) {
            let form = document.getElementById('formEvento');
            form.action = "{{ route('agenda.event.store') }}";
            form.method = "POST";

            document.getElementById('method_field').value = 'POST';
            if (!form.querySelector('input[name="_method"]')) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'POST';
                form.appendChild(methodInput);
            }

            document.getElementById('evt-status').value = info.event.extendedProps.status || '';
            document.getElementById('evt-inicio').value = formatDateToInput(new Date(info.event.start)) || '';
            document.getElementById('evt-fim').value = formatDateToInput(new Date(info.event.end)) || '';
            document.getElementById('evt-resp').value = info.event.extendedProps.responsavel_id || '';
            document.getElementById('evt-tel').value = info.event.extendedProps.telefone || '';
            document.getElementById('evt-email').value = info.event.extendedProps.email || '';
            document.getElementById('evt-obs').value = info.event.extendedProps.observacao || '';
            document.getElementById('evt-tipo').value = info.event.extendedProps.tipo_id || '';


            var instance = M.Modal.getInstance(document.getElementById('detalheEvento'));
            instance.open();
    },
    dateClick: function(info) {
      const inicioDate = new Date(info.date);
      const fimDate = new Date(info.date);
      fimDate.setHours(fimDate.getHours() + 1); // adiciona 1h

      const inicio = formatDateToInput(inicioDate);
      const fim = formatDateToInput(fimDate);

        document.getElementById('evt-tipo').value   = '';
        document.getElementById('evt-status').value = '';
        document.getElementById('evt-inicio').value = inicio;
        document.getElementById('evt-fim').value    = fim;
        document.getElementById('evt-resp').value   = '';
        document.getElementById('evt-tel').value    = '';
        document.getElementById('evt-email').value  = '';
        document.getElementById('evt-clie').value = ''; 

        M.FormSelect.init(document.querySelectorAll('select'));
        var instance = M.Modal.getInstance(document.getElementById('detalheEvento'));
        instance.open();
    }
    });
    calendar.render();

    // Datepicker
    var elems = document.querySelectorAll('.datepicker');
    M.Datepicker.init(elems, {
        format: 'dd/mm/yyyy',
        yearRange: [1900, 2050],
        i18n: {
            cancel: 'Cancelar', clear: 'Limpar', done: 'Selecionar',
            months: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthsShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            weekdays: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            weekdaysShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            weekdaysAbbrev: ['D','S','T','Q','Q','S','S']
        },
        onSelect: function(date) {
            calendar.gotoDate(date);
        }
    });
});

</script>


@endsection
