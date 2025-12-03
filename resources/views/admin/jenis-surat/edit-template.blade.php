<x-app-layout>
    @php
        $title = 'Edit Template Surat';
    @endphp
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-code mr-2 text-blue-600"></i>Edit Template Surat
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.jenis_surat.preview.template', $jenisSurat->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                   target="_blank">
                    <i class="fas fa-eye mr-2"></i>Preview
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Template Editor -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-code mr-2 text-blue-600"></i>Editor Template
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Edit template surat untuk jenis surat: <strong>{{ $jenisSurat->nama }}</strong></p>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('admin.jenis_surat.update.template', $jenisSurat->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-6">
                                    <label for="template" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih Template <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        @php
                                            $availableTemplates = ['default', 'sktm', 'domisili', 'usaha'];
                                        @endphp
                                        
                                        @foreach($availableTemplates as $template)
                                            <div class="template-option">
                                                <input type="radio" 
                                                       id="template_{{ $template }}" 
                                                       name="template" 
                                                       value="{{ $template }}" 
                                                       class="hidden peer" 
                                                       {{ old('template', $jenisSurat->template) == $template ? 'checked' : '' }}
                                                       required>
                                                <label for="template_{{ $template }}" 
                                                       class="inline-flex items-center justify-between w-full p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                                                            <i class="fas fa-file-alt text-blue-600"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-lg font-semibold">{{ strtoupper($template) }}</div>
                                                            <div class="text-sm">Template {{ $template }}</div>
                                                        </div>
                                                    </div>
                                                    <i class="fas fa-check-circle text-xl opacity-0 peer-checked:opacity-100"></i>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @error('template')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <div class="mt-4 text-sm text-gray-600">
                                        <p><i class="fas fa-info-circle mr-2"></i>Template akan digunakan untuk generate PDF surat. Pilih template yang sesuai dengan jenis surat.</p>
                                    </div>
                                </div>

                                <!-- Template Code Editor -->
                                <div class="mb-6">
                                    <label for="template_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Template Content (Advanced)
                                    </label>
                                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">Template Code Editor</span>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">HTML/Blade</span>
                                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea class="w-full h-64 font-mono text-sm p-4 focus:outline-none resize-none" 
                                                  id="template_content" 
                                                  name="template_content" 
                                                  placeholder="&lt;!DOCTYPE html&gt;&#10;&lt;html&gt;&#10;&lt;head&gt;&#10;    &lt;title&gt;Template Surat&lt;/title&gt;&#10;&lt;/head&gt;&#10;&lt;body&gt;&#10;    &lt;!-- Template content here --&gt;&#10;&lt;/body&gt;&#10;&lt;/html&gt;">{{ old('template_content', $jenisSurat->template_content ?? '') }}</textarea>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        <p><i class="fas fa-lightbulb mr-1"></i>Gunakan variabel: <code class="px-2 py-1 bg-gray-100 rounded">{{ '{user.nama}' }}</code>, <code class="px-2 py-1 bg-gray-100 rounded">{{ '{user.alamat}' }}</code>, <code class="px-2 py-1 bg-gray-100 rounded">{{ '{data.field_name}' }}</code></p>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                                    <a href="{{ route('admin.jenis_surat.show', $jenisSurat->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fas fa-save mr-2"></i>Simpan Template
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Variables & Preview -->
                <div class="space-y-6">
                    <!-- Available Variables -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-code-branch mr-2 text-blue-600"></i>Variabel Tersedia
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Gunakan variabel ini dalam template</p>
                            </div>

                            <!-- Data User -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-user mr-2 text-green-600"></i>Data User
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{user.nama}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Nama lengkap user</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{user.nama}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{user.nik}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">NIK user</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{user.nik}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{user.alamat}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Alamat user</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{user.alamat}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{user.tempat_lahir}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Tempat lahir user</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{user.tempat_lahir}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{user.tanggal_lahir}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Tanggal lahir user</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{user.tanggal_lahir}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Surat -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-envelope mr-2 text-yellow-600"></i>Data Surat
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{surat.nomor_surat}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Nomor surat</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{surat.nomor_surat}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{surat.tanggal}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Tanggal pembuatan</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{surat.tanggal}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                        <div>
                                            <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{surat.perihal}' }}</code>
                                            <p class="text-xs text-gray-500 mt-1">Perihal surat</p>
                                        </div>
                                        <button type="button" 
                                                @click="insertVariable('{surat.perihal}')"
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Custom -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-list-check mr-2 text-purple-600"></i>Data Custom
                                </h4>
                                @php
                                    $persyaratan = json_decode($jenisSurat->persyaratan, true);
                                @endphp
                                
                                @if($persyaratan && count($persyaratan) > 0)
                                    <div class="space-y-2">
                                        @foreach($persyaratan as $syarat)
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                                <div>
                                                    <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ '{data.' . $syarat['field'] . '}' }}</code>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $syarat['label'] }}</p>
                                                </div>
                                                <button type="button" 
                                                        @click="insertVariable('{{ '{data.' . $syarat['field'] . '}' }}')"
                                                        class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-exclamation-circle text-gray-400 text-2xl mb-2"></i>
                                        <p class="text-gray-500 text-sm">Belum ada persyaratan</p>
                                        <a href="{{ route('admin.jenis_surat.edit', $jenisSurat->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                            <i class="fas fa-plus mr-1"></i>Tambah persyaratan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Template Preview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Card Header -->
                            <div class="mb-6 pb-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-eye mr-2 text-blue-600"></i>Template Preview
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Contoh tampilan template</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                                <h5 class="text-center mb-6 font-bold text-lg">SURAT KETERANGAN</h5>
                                
                                <p class="mb-4">Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
                                
                                <div class="ml-6 mb-6 space-y-2">
                                    <p>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="font-semibold text-blue-600">{{ '{user.nama}' }}</span></p>
                                    <p>NIK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="font-semibold text-blue-600">{{ '{user.nik}' }}</span></p>
                                    <p>Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="font-semibold text-blue-600">{{ '{user.alamat}' }}</span></p>
                                    <p>Tempat/Tgl Lahir : <span class="font-semibold text-blue-600">{{ '{user.tempat_lahir}' }}, {{ '{user.tanggal_lahir}' }}</span></p>
                                </div>
                                
                                <p class="mb-6">Dengan ini menerangkan bahwa orang tersebut di atas benar-benar ...</p>
                                
                                <div class="text-right mt-10">
                                    <p>Kelurahan Digital, {{ date('d F Y') }}</p>
                                    <p class="mt-8">Hormat kami,</p>
                                    <p class="font-bold mt-2">KEPALA KELURAHAN</p>
                                    <p class="mt-12 font-bold">Dr. Budi Santoso, M.Si.</p>
                                    <p class="text-sm">NIP. 197001011995011001</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Function to insert variable into template editor
        function insertVariable(variable) {
            const textarea = document.getElementById('template_content');
            if (!textarea) return;
            
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            
            textarea.value = text.substring(0, start) + variable + text.substring(end);
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = start + variable.length;
            
            // Show success feedback
            showInsertFeedback(variable);
        }
        
        // Show feedback when variable is inserted
        function showInsertFeedback(variable) {
            // Remove any existing feedback
            const existingFeedback = document.getElementById('variable-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            // Create feedback element
            const feedback = document.createElement('div');
            feedback.id = 'variable-feedback';
            feedback.className = 'fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50 animate-pulse';
            feedback.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Variable <code class="ml-1 bg-green-200 px-2 py-1 rounded">${variable}</code> inserted!</span>
                </div>
            `;
            
            document.body.appendChild(feedback);
            
            // Remove feedback after 3 seconds
            setTimeout(() => {
                feedback.remove();
            }, 3000);
        }
        
        // Add Alpine.js data
        document.addEventListener('alpine:init', () => {
            Alpine.data('templateEditor', () => ({
                init() {
                    // Initialize any template editor functionality
                }
            }));
        });
        
        // Template selection feedback
        document.addEventListener('DOMContentLoaded', function() {
            const templateOptions = document.querySelectorAll('.template-option input[type="radio"]');
            
            templateOptions.forEach(option => {
                option.addEventListener('change', function() {
                    const templateName = this.value;
                    const templateLabel = this.nextElementSibling.querySelector('.text-lg').textContent;
                    
                    // Show template description based on selection
                    showTemplateDescription(templateName, templateLabel);
                });
            });
            
            // Show description for initially selected template
            const selectedTemplate = document.querySelector('.template-option input[type="radio"]:checked');
            if (selectedTemplate) {
                const templateName = selectedTemplate.value;
                const templateLabel = selectedTemplate.nextElementSibling.querySelector('.text-lg').textContent;
                showTemplateDescription(templateName, templateLabel);
            }
        });
        
        function showTemplateDescription(templateName, templateLabel) {
            const descriptions = {
                'default': 'Template standar untuk semua jenis surat.',
                'sktm': 'Template khusus untuk Surat Keterangan Tidak Mampu.',
                'domisili': 'Template khusus untuk Surat Keterangan Domisili.',
                'usaha': 'Template khusus untuk Surat Keterangan Usaha.'
            };
            
            // Remove any existing description
            const existingDesc = document.getElementById('template-description');
            if (existingDesc) {
                existingDesc.remove();
            }
            
            // Create description element
            const description = document.createElement('div');
            description.id = 'template-description';
            description.className = 'mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg';
            description.innerHTML = `
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800">${templateLabel}</h4>
                        <p class="text-sm text-blue-700 mt-1">${descriptions[templateName] || 'Template untuk berbagai keperluan surat.'}</p>
                    </div>
                </div>
            `;
            
            // Insert after template selection section
            const templateSection = document.querySelector('label[for="template"]');
            if (templateSection && templateSection.parentNode) {
                templateSection.parentNode.insertBefore(description, templateSection.nextElementSibling);
            }
        }
    </script>
    @endpush
</x-app-layout>