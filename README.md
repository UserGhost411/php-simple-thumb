# php-simple-thumb
A simple thumbnail generation script written in PHP.

# Example Usage
```HTML
<img src="img.php?image=photo.jpg&size=300x150&quality=40">
```

# Parameters
| Parameters | Example value  | Description  |
| ------- | --- | --- |
| image | photo.jpg | Absolute path or local URL to the source image |
| size | 300x150 | Width And height Your thumbnails Image , if param size is blank : original size / 2 |
| quality | 50 | compress quality from your thumbnails , if param quality is blank : quality=10%  |

# License

php-simple-thumb is licensed under the [MIT license](LICENSE), see [LICENSE.md](LICENSE) for details.
