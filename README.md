<p align="center">
  <a href="" rel="noopener">
 <img width=430px height=350px src="public/readme/crawler.jpg" alt="Project logo"></a>
</p>

<h3 align="center" style="color:#f08d8d">Laravel News Crawler API</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/afshin-phpy/The-Documentation-Compendium.svg)](https://github.com/afshin-phpy/The-Documentation-Compendium/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/afshin-phpy/The-Documentation-Compendium.svg)](https://github.com/afshin-phpy/The-Documentation-Compendium/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center" > This API allows you to fetch and manage news articles from various sources.
    <br> 
</p>

# 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Built Using](#built_using)
- [Authors](#authors)
- [API-Endpoints](#api)

# 🧐 About <a name = "about"></a>

Laravel News Crawler API is a web application that crawls and aggregates news articles from various sources, such as NewsAPI, Guardian API, and Mediastack API, and stores them in a database. It provides a RESTful API to access the news data.

# 🏁 Getting Started <a name = "getting_started"></a>

There is two options for installing this app:

  - [By Laravel Sail](#by_sail)

  - [Without Laravel Sail](#without_sail)

## <span style='color:#46e8d2'>Install via Laravel sail</span> <a name = "by_sail"></a>
To install and run this project, you will need to have Docker and Composer installed on your machine. Then, follow these steps:

1. Clone this repository to your local machine.
2. Copy the .env.example file to .env and fill in the required variables, such as the API keys for the news sources.
3. Run composer install to install the PHP dependencies.
```
composer install
```
4. Run ./vendor/bin/sail up to start the Docker containers.

```
./vendor/bin/sail up -d
```

5. Run ./vendor/bin/sail artisan migrate to create the database tables.

```
./vendor/bin/sail artisan migrate
```

6. Run ./vendor/bin/sail artisan queue:work to start the queue worker.

```
./vendor/bin/sail artisan queue:work
```

7. Run ./vendor/bin/sail artisan schedule:run to start the scheduler that fetches data from the news sources every hour.

```
./vendor/bin/sail artisan schedule:run
```

### Sail alias

To add the ./vendor/bin/sail directory to your bash environment, you can modify your shell configuration file. If you're using Bash, it's likely that you have a .bashrc or .bash_profile file in your home directory. Here's how you can add the ./vendor/bin/sail directory to your PATH:

 1. Open your shell configuration file in a text editor. Use one of the following commands based on your shell:

```
nano ~/.bashrc
```
2. Add the following line at the end of the file:
```
alias sail='bash ./vendor/bin/sail'
```
 3. Save the file and exit the text editor.

 4. To apply the changes immediately, you can either restart your terminal or run the following command:

 ```
 source ~/.bashrc   # for Bash
 ```

Now, you should be able to use sail commands from anywhere in your terminal.




## <span style='color:#e8ce3a'>Install without Laravel sail</span> <a name = "without_sail"></a>
To install and run this project with this option, you need webserver like (xampp, wamp, and etc) and Composer installed on your machine. Then, follow these steps:

1. Clone this repository to your local machine.
2. Copy the .env.example file to .env and fill in the required variables, such as the API keys for the news sources.
3. Run composer install to install the PHP dependencies.
```
composer install
```
4. Create database with tools like phpmyadmin

5. Change DB_DATABASE with your prefer database name

6. Change from mysql to DB_HOST to 127.0.0.1

7. Run php artisan migrate to create the database tables.

```
php artisan migrate
```

8. Run php artisan queue:work to start the queue worker.

```
php artisan queue:work
```

9. Run php artisan schedule:run to start the scheduler that fetches data from the news sources every hour.

```
php artisan schedule:run
```



## 🔧 Running the tests <a name = "tests"></a>

You can use following codes to run testcases:

 - when using sail:
    ```
    sail artisan test
    ```
  - when don't use sail:
    ```
    php artisan test
    ```


# ⛏️ Built Using <a name = "built_using"></a>

- [Laravel 10.x](https://www.Laravel.com) 
- [MySQL Database](https://www.mysql.com/)
- [Laravel Sail](https://laravel.com/docs/10.x/sail)
- [Laravel Queue](https://laravel.com/docs/10.x/queues)
- [News API](https://newsapi.org/)
- [Guardian API](https://open-platform.theguardian.com/documentation/search)
- [Mediastack API](https://mediastack.com/documentation)

# ✍️ Authors <a name = "authors"></a>

- [@afshin-phpy](https://github.com/afshin-phpy) - Idea & Initial work


# 🚀 API-Endpoints <a name = "api"></a>

The API provides the following endpoint(s):

- POST /api/v1/news/search

## Description

This end-point allows you to search for news articles from various sources and categories. You can specify the keywords, the number of results, and the date range of the articles.

### <span style='color:#2e8ee8'>Parameters</span>
    •  query: The query string to search in title. This parameter is required and cannot be empty.

    •  category(optional): This parameter for filtering data by their categories, that includes (business, entertainment, general, sports, technology, news, and science).

    •  source(optional): This parameter is for filtering data by their source, exp:Forbes, UPROXX, NBCSports.com, and etc.

    •  author(optional): This parameter is for filtering data by their author.

    •  from_date(optional): The from_date of the articles to return. The format is YYYY-MM-DD.

    •  to_date(optional): The to_date of the articles to return. The format is YYYY-MM-DD.

### <span style='color:#28e09d'>Response</span>
The response is a JSON object with the following fields:

      -  results: The number of articles returned.

      -  data: An array of articles, each with the following fields:

        •  title: The title of the article.

        •  author: The author of the article.

        •  category: The category of the article.

        •  source: The source of the article.

        •  content: The content of the article, truncated to 200 characters.

        •  reference_url: The URL of the article.

        •  publish_date: The date of the article, in YYYY-MM-DD HH:MM:SS format.

### <span style='color:#e84694'>Example</span>
The following is an example of a request and a response for the end-point /api/v1/news/search:


```
  Post /api/v1/news/search

  Host: localhost

  Content-Type: application/json
  

  {
    "query": "technology",
    
    "category": "global"
  } 

```



#### <span style='color:#46e8cd'>Json Response</span>

```
{ 

    "results": 1,

    "data": [
      {
        "title": "Micro-mobility Market to surpass $231 Bn by 2032.",
        "author": "Global Market Insights Inc.",
        "category": "technology",
        "source": "GlobeNewswire",
        "content": "Selbyville, Delaware, Nov. 14, 2023 (GLOBE NEWSWIRE)...",
        "reference_url": "url to website",
        "publish_date": "2023-11-14 23:00:00"
      }
    ]
}

```