@extends('layout')

@section('head_css')
@parent
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.0/jsoneditor.min.css" rel="stylesheet" type="text/css">
  <style>
    #spinning-wheel {
      border: none;
    }
    #spinning-wheel::after {
      border: 2px solid #e85048;
      border-right-color: transparent;
      border-top-color: transparent;
    }
    .jsoneditor-menu {
        background-color: #413f4b;
        border-bottom: 1px solid #413f4b;
    }
    .jsoneditor-poweredBy {
        display: none;
    }
    .jsoneditor {
        border: thin solid #413f4b;
    }
  </style>
@endsection

@section('content')
<div class="container mt-4 mb-4">
<div class="box">
    <div class="content">
        <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h1 class="title is-4">
                Fichier en édition: {{ $filename }}
            </h1>
            <div class="buttons">
                <a href="{{ url('/_admin/json-files/' . $type ) }}" class="button">
                    Retour
                </a>
                <button onclick="saveJson()"
                        class="button is-primary">
                    Sauvegarder les changements
                </button>
                <button onclick="showConfirmModal()"
                        class="button is-primary">
                    Re-importer le fichier
                </button>
            </div>
        </div>

        <!-- Loading Box -->
        <div id="loading-box" class="modal">
          <div class="modal-background"></div>
          <div class="modal-card">
              <header class="modal-card-head">
                  <p class="modal-card-title">Veuillez patienter...</p>
              </header>
              <section class="modal-card-body has-text-centered" style="display: flex; align-items: center; justify-content: center;gap: 30px;">
                Opération en cours... <span class="is-loading is-large button" id="spinning-wheel"></span>
              </section>
          </div>
        </div>

        <div id="success" class="mt-4 mb-4 is-hidden">
            <div class="notification is-success">
                <span id="status"></span>
            </div>
        </div>

        <div id="danger" class="mt-4 mb-4 is-hidden">
            <div class="notification is-danger">
                <span id="danger-status"></span>
            </div>
        </div>

        <div id="jsoneditor" style="height: 500px;"></div>

        <!-- Confirm Modal -->
        <div class="modal" id="confirm-modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Confirmer l'import</p>
                    <button class="delete" aria-label="close" onclick="hideConfirmModal()"></button>
                </header>
                <section class="modal-card-body">
                    Attention, l'import écrasera les données du lieux déjà présentes !
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-danger" onclick="confirmImport()">Importer</button>
                    <button class="button" onclick="hideConfirmModal()">Annuler</button>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_js')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.0/jsoneditor.min.js"></script>
<script>
    let editor;
    // Create the editor
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('jsoneditor');
        const options = {
            mode: 'code',
            onError: function (err) {
                alert(err.toString());
            },
            onModeChange: function (newMode, oldMode) {
                console.log('Mode switched from', oldMode, 'to', newMode);
            },
        };

        editor = new JSONEditor(container, options);

        // Set the initial JSON content
        const initialJson = @json($content);
        editor.set(JSON.parse(initialJson));


        let nameLineNumber;
        switch ("{{$type}}") {
            case "general":
                nameLineNumber = 63;
                break;
            case "social":
                nameLineNumber = 36;
                break;
            case "environmental":
                nameLineNumber = 45;
                break;
            default:
                nameLineNumber = 1;
                break;
        }
        editor.aceEditor.gotoLine(nameLineNumber);
    });

    function displaySuccessMessage(message) {
        const success = document.getElementById('success');
        const status = document.getElementById('status');
        status.innerHTML = message;

        success.classList.remove('is-hidden');
        setTimeout(() => {
          success.classList.add('is-hidden');
        }, 6000);
    }

    function displayDangerMessage(message) {
        const danger = document.getElementById('danger');
        const status = document.getElementById('danger-status');
        status.innerHTML = message;

        danger.classList.remove('is-hidden');
        setTimeout(() => {
            danger.classList.add('is-hidden');
        }, 6000);
    }

    // Save the JSON content
    async function saveJson() {
        try {
            document.getElementById('loading-box').classList.add('is-active');

            const content = JSON.stringify(editor.get(), null, 2);

            const response = await fetch('{{ url("/_admin/json-files/$type/$filename") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content })
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Failed to save changes');
            }

            displaySuccessMessage('Changements sauvegardés avec succès !');

        } catch (error) {
            displayDangerMessage('Error saving changes: ' + error.message);
        } finally {
            document.getElementById('loading-box').classList.remove('is-active');
        }
    }

    // Import the file
    async function importFile() {
        try {
            document.getElementById('loading-box').classList.add('is-active');

            const content = JSON.stringify(editor.get(), null, 2);

            const response = await fetch('{{ url("/_admin/json-files/import/$type/$filename") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content })
            });

            const result = await response.json();
            displaySuccessMessage('Le lieu a été importé avec succès !');

            if (!response.ok) {
                throw new Error(result.error || 'Failed to import');
            }
        } catch (error) {
            displayDangerMessage(error);
        } finally {
            document.getElementById('loading-box').classList.remove('is-active');
        }
    }


    function showConfirmModal() {
        document.getElementById("confirm-modal").classList.add("is-active");
    }

    function hideConfirmModal() {
        document.getElementById("confirm-modal").classList.remove("is-active");
    }

    function confirmImport() {
        hideConfirmModal();
        importFile();
    }
</script>
@endsection
