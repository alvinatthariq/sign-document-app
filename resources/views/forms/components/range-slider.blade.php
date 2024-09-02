<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">

        <!-- Interact with the `state` property in Alpine.js -->
         <!-- class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" id="signature" width="300" height="100" -->
         <!-- x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }" -->

        <canvas
            x-data="signaturePad()"
            x-init="init()"
            x-ref="signatureCanvas"
            x-model="state"
            id="signature" name="signature"
            style="border:1px solid grey">
        </canvas>

        <!-- Clear Signature Button -->
        <button
            type="button"
            @click="clearSignature"
            class="mt-2 px-4 py-2 bg-red-500 rounded">
            Clear Signature
        </button>

        <!-- <textarea x-model="state" id="signature" name="signature"></textarea> -->
    </div>
</x-dynamic-component>

<script>
function signaturePad() {
    return {
        drawing: false,
        signatureData: '',
        prevX: null,
        prevY: null,
        ctx: null,

        init() {
            const canvas = this.$refs.signatureCanvas;
            this.ctx = canvas.getContext("2d");

            canvas.addEventListener("mousemove", this.draw.bind(this));
            canvas.addEventListener("mouseup", this.stop.bind(this));
            canvas.addEventListener("mousedown", this.start.bind(this));
            canvas.addEventListener("touchmove", this.draw.bind(this));
            canvas.addEventListener("touchend", this.stop.bind(this));
            canvas.addEventListener("touchstart", this.start.bind(this));
        },

        start(e) {
            this.drawing = true;
        },

        stop() {
            this.drawing = false;
            this.prevX = this.prevY = null;
            this.signatureData = this.$refs.signatureCanvas.toDataURL();
            this.state = this.signatureData;
            console.log(this.signatureData); // for debugging
        },

        draw(e) {
            if (!this.drawing) return;
            const { clientX, clientY } = this.getCoordinates(e);
            const currX = clientX - this.$refs.signatureCanvas.offsetLeft;
            const currY = clientY - this.$refs.signatureCanvas.offsetTop;

            if (!this.prevX && !this.prevY) {
                this.prevX = currX;
                this.prevY = currY;
            }

            this.ctx.beginPath();
            this.ctx.moveTo(this.prevX, this.prevY);
            this.ctx.lineTo(currX, currY);
            this.ctx.strokeStyle = 'black';
            this.ctx.lineWidth = 2;
            this.ctx.stroke();
            this.ctx.closePath();

            this.prevX = currX;
            this.prevY = currY;
        },

        getCoordinates(e) {
            if (e.type.includes('touch')) {
                const touch = e.touches[0] || e.changedTouches[0];
                return { clientX: touch.clientX, clientY: touch.clientY };
            }
            return { clientX: e.clientX, clientY: e.clientY };
        },

        onSubmit() {
            console.log({
                'name': document.getElementsByName('name')[0]?.value,
                'signature': this.signatureData,
            });
        },

        clearSignature() {
            // Clear the canvas and reset the state
            this.ctx.clearRect(0, 0, this.$refs.signatureCanvas.width, this.$refs.signatureCanvas.height);
            this.signatureData = '';
            this.state = '';  // Clear the Alpine.js state as well
        },
    };
}
</script>
