<script setup lang="ts">
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useConfirm } from '@/Composables/useConfirm.js';
import { nextTick, ref, watchEffect } from 'vue';

const { state, confirm, cancel } = useConfirm();
const cancelButtonRef = ref<HTMLButtonElement | null>(null);

watchEffect(async function () {
  if (state.show) {
    await nextTick();
    // @ts-ignore  $el does exist but Vue/TS together = be dumb sometimes
    cancelButtonRef.value?.$el.focus();
  }
});
</script>

<template>
  <ConfirmationModal :show="state.show">
    <template #title>
      {{ state.title }}
    </template>
    <template #content>
      {{ state.message }}
    </template>
    <template #footer>
      <SecondaryButton ref="cancelButtonRef" id="cancel-button" @click="cancel"
        >Cancel
      </SecondaryButton>
      <PrimaryButton @click="confirm" class="ml-3">Confirm </PrimaryButton>
    </template>
  </ConfirmationModal>
</template>
