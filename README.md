# Blog Series Extension [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PascalKleindienst/october-blogseries-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PascalKleindienst/october-blogseries-extension/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/PascalKleindienst/october-blogseries-extension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/PascalKleindienst/october-blogseries-extension/build-status/master)
This plugin is an extension to the [RainLab.Blog](https://github.com/rainlab/blog-plugin) plugin. With this extension you can group posts into series

## Components
### BlogSeries
The `blogSeries` component outputs the series and lists all posts which belong to the series

#### Attributes
- **Slug** - Look up the series using the supplied slug value.
- **No Posts Message** - Message to show if no posts where found.
- **Category Page** - The page where the blog posts are filtered by a category.
- **Post Page** - The page where single blog posts are displayed.

### BlogSeriesList
The `blogSeriesList` component displays a list of blog series on the page

#### Attributes
- **Display empty series** - Show series that do not have any posts.
- **Series Page** - The page where the series is displayed *(the page with the `blogSeries` component)*.

### PostNavigation
The `postNavigation` component displays a navigation for the current posts series. This component should be included on the same page
as the `blogPost` component because it requires the post slug

#### Example
```
{% component 'blogPost' %}
{% component 'postNavigation' %}
```

#### Attributes
- **Slug** - Look up the post using the supplied slug value.
- **Small Navigation** - Display a small "Previous/Next Navigation" instead of a full post list.
- **Series Page** - The page where the single series are displayed.
- **Post Page** - The page where single blog posts are displayed.