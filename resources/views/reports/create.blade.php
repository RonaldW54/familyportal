<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Neuen Bericht erstellen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Das Alpine-Setup kommt auf das Formular --}}
            <form 
                x-data="tiptapEditor()" 
                x-init="init()" 
                method="POST" 
                action="{{ route('reports.store') }}" 
                @submit="syncContentBeforeSubmit()"
            >
                @csrf
                <input type="hidden" name="content_json" id="content_json">
                <input type="hidden" name="content_html" id="content_html">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Titel</label>
                            <input type="text" name="title" id="title" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="border border-gray-300 rounded-md">
                            <div class="p-2 border-b bg-gray-50 flex items-center gap-2">
                                <span x-show="!isReady" class="text-xs text-gray-500">Editor wird geladen...</span>
                                <template x-if="isReady">
                                    <div class="flex items-center gap-2">
                                        <button @click.prevent="editor.chain().focus().toggleBold().run()" :class="{ 'bg-gray-300': editor.isActive('bold') }" type="button" class="p-1 rounded hover:bg-gray-200"><strong>B</strong></button>
                                        <button @click.prevent="editor.chain().focus().toggleItalic().run()" :class="{ 'bg-gray-300': editor.isActive('italic') }" type="button" class="p-1 rounded hover:bg-gray-200"><em>I</em></button>
                                    </div>
                                </template>
                            </div>
                            <div x-ref="editor" class="p-4 min-h-[20rem] prose max-w-none"></div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 ...">Bericht speichern</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Wir laden Tiptap NUR auf dieser Seite und initialisieren es DANACH --}}
    @push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tiptapEditor', () => ({
            editor: null,
            isReady: false,
            init() {
                // Warte, bis die 'defer'-Skripte sicher geladen sind
                setTimeout(() => {
                    if (window.Tiptap && window.TiptapStarterKit) {
                        this.editor = new Tiptap.Core.Editor({
                            element: this.$refs.editor,
                            extensions: [ Tiptap.StarterKit.default.configure() ],
                            content: '<p>Hier beginnt Ihr Bericht...</p>',
                        });
                        this.isReady = true;
                    } else {
                        console.error('Tiptap-Bibliotheken nicht rechtzeitig geladen.');
                    }
                }, 150); // Eine kleine Sicherheits-Verzögerung
            },
            syncContentBeforeSubmit() {
                if (this.editor) {
                    document.getElementById('content_json').value = JSON.stringify(this.editor.getJSON());
                    document.getElementById('content_html').value = this.editor.getHTML();
                }
            }
        }));
    });
</script>
@endpush
</x-app-layout>