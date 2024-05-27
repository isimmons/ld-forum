import '@testing-library/jest-dom'
import {describe, it, expect, vi} from 'vitest';
import {render, screen} from '@testing-library/vue';
import {config, shallowMount, mount} from '@vue/test-utils';
import Welcome from "@/Pages/Welcome.vue";

vi.mock("@inertiajs/vue3", async (importOriginal) => {
  const actual = await importOriginal<typeof Welcome>()
  return {
    __esModule: true,
    ...actual,
    usePage: () => ({
      props:
        {
          auth: {user: {}}
        }
    }),
  }
})


describe('Welcome', () => {
  it('Shows the welcome message', async () => {
    const foo = shallowMount(Welcome, {
      props: {
        canLogin: true, canRegister: true, laravelVersion: '2', phpVersion: '8.3'
      },
      global: {
        mocks: {
          $page: {
            props:
            {
              auth: {user: {}}
            }
          },
        },
      },
    });
    console.log(foo.html())
    const dashboardLink = await screen.findByRole('link');
  });
});
