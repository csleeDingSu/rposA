<template>
    <div>
        <a 
            class="btn btn-rectangle"
            @click="$modal.show('invitation-modal')"
            >
            test
        </a>

        <modal
            name="invitation-modal"
        >
            <div>
                contents
            </div>
        </modal>
    </div>
</template>

<script>
    export default {}
</script>
