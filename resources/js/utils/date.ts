import { formatDistance, parseISO } from 'date-fns';

export const relativeDate = (date: string) => {
  return formatDistance(parseISO(date), new Date(), {
    addSuffix: true,
  });
};
