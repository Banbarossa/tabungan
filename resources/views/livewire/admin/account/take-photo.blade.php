<div>
    <div class="relative max-w-sm">
        {{-- Alert Start --}}
        <div x-show="isUploading" class="absolute top-0 left-0 right-0 w-full ">
            <div class="w-full h-3 bg-gray-200 rounded">
                <div class="h-3 bg-teal-500 rounded" x-bind:style="'width:' + uploadProgress + '%'"></div>
            </div>
            <p class="mt-2 text-xs text-center text-gray-600" x-text="uploadProgress + '%'"></p>
        </div>
        @if (isset($jarak_lokasi_allowed) && !$jarak_lokasi_allowed)
            <div
                class="absolute flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg left-3 right-3 top-3 bg-yellow-50 bg-opacity-60"
                role="alert">
{{--                <x-icon.info class="inline w-4 h-4 shrink-0 me-3"></x-icon.info>--}}
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Peringatan!</span> Sistem mendeteksi anda berada diluar radius
                </div>
            </div>

        @endif


        <video id="video" autoplay playsinline muted class="w-full border rounded-md shadow "></video>
        <div class="absolute left-0 right-0 grid grid-cols-3 px-3 bottom-3">
                <div></div>
                <div class="flex items-center justify-center">
                    <button
                        type="button"
                        class="p-3 border-4 border-teal-100 rounded-full group"
                        x-data="{ takePhoto() {
                                        let video = document.getElementById('video');
                                        let canvas = document.getElementById('canvas');
                                        let context = canvas.getContext('2d');

                                        const maxWidth = 800;
                                        const scale = maxWidth / video.videoWidth;

                                        canvas.width = maxWidth;
                                        canvas.height = video.videoHeight * scale;

                                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                                        canvas.toBlob(blob => {
                                            let file = new File([blob], 'photo.jpg',{type: 'image/jpeg'});
                                            this.isUploading =true;

                                            $wire.upload('photo', file, ()=>{
                                                $wire.call('store');

                                            },(error)=>{
                                                console.error('Upload gagal:', error);
                                            },(event) => {
                                                this.uploadProgress = event.detail.progress;
                                            });
                                        },'image/jpeg',0.7);
                                    } }"
                        x-on:click="takePhoto()"
                    >
                        <flux:icon.camera/>
                    </button>

                </div>
        </div>

    </div>
    <canvas id="canvas" class="hidden"></canvas>

    @script
    <script>
        let video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({video: true})
            .then(stream => video.srcObject = stream)
            .catch(err => console.error("Akses kamera gagal", err));
    </script>
    @endscript
</div>
