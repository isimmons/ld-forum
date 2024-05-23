export type PaginationLink = {
  label: string;
  url: string;
  active: boolean;
};

export type PostTopic = {
  id: number;
  name: string;
  slug: string;
};

export type User = {
  id: number;
  name: string;
  email: string;
};

export type Team = {
  id: number;
  name: string;
};

export type InertiaAuthUser = {
  id: number;
  name: string;
  email: string;
  profile_photo_path: string;
  profile_photo_url: string;
  two_factor_enabled: boolean;
  two_factor_confirmed_at: Date | null;
  email_verified_at: Date;
  created_at: Date;
  updated_at: Date;
  current_team_id: number | null;
  current_team: string;
  all_teams: Array<Team>;
};

export type InertiaSharedProps = {
  auth: { user: InertiaAuthUser };
  permissions: { create_posts: boolean };
  jetstream: {
    hasApiFeatures: boolean;
    managesProfilePhotos: boolean;
    hasTeamFeatures: boolean;
    canCreateTeams: boolean;
  };
};

export type Post = {
  id: number;
  title: string;
  body: string;
  created_at: Date;
  updated_at: Date;
  routes: { show: string };
  topic: PostTopic;
  user: User;
};

export type PostMeta = {
  links: Array<PaginationLink>;
  from: number;
  to: number;
  total: number;
};
