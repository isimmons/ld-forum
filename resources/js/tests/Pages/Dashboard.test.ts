import { it, expect } from 'vitest';
import { screen, render } from '@testing-library/vue';
import Dashboard from '@/Pages/Dashboard.vue';

const AppLayoutStub = {
  props: ['title'],
  template: `
    <div>
        <div data-testid="title">{{ title }}</div>
        <slot name="header"></slot>
        <slot></slot>
    </div>`,
};

it('passes the "title" prop and "header" slot content to a layout component', async () => {
  render(Dashboard, {
    global: {
      stubs: {
        AppLayout: AppLayoutStub,
        Welcome: true,
      },
    },
  });

  const title = screen.getByTestId('title');
  expect(title).toHaveTextContent(/dashboard/i);

  expect(
    screen.getByRole('heading', { name: /dashboard/i }),
  ).toBeInTheDocument();
});
