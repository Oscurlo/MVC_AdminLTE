$(document).ready(() => {
    const Config = CONFIG()
    const URL_BACKEND = `${Config.BASE_SERVER}/assets/menu/menu.php`

    const handleToggleDark = () => {
        const $navbar = $(`nav.navbar`)
        const $sidebar = $(`aside.main-sidebar`)
        const $body = $(`body`)

        // navbar
        if ($navbar.hasClass("navbar-light"))
            $navbar.removeClass("bg-white navbar-light").addClass("bg-dark navbar-dark")
        else
            $navbar.removeClass("bg-dark navbar-dark").addClass("bg-white navbar-light")

        // sidebar
        if ($sidebar.attr("class").includes("-light-"))
            $sidebar.attr("class", $sidebar.attr("class").replace("-light-", "-dark-"))
        else
            $sidebar.attr("class", $sidebar.attr("class").replace("-dark-", "-light-"))

        // body
        $body.toggleClass("dark-mode")

    }, handleDisconnect = async () => {
        const request = await fetch(`${URL_BACKEND}?action=disconnect`)

        if (request.status === 200) window.location.href = Config.BASE_SERVER
    }, handleInternalRoute = function (e) {
        e.preventDefault()

        const $this = $(this)
        const title = $this.text()
        const url = $this.attr("href")

        if ($this.hasClass("nav-link")) {
            const $active = $(`.nav-link.active`)
            $this.addClass("active")
            $active.removeClass("active")
        }

        route(title, url, true)
    }

    $(`[data-widget="toggle-dark"]`).on("click", handleToggleDark)
    $(document).on(`click`, `#btnDisconnect`, handleDisconnect)
    $(document).on(`click`, `[href*="${Config.BASE_SERVER}"]`, handleInternalRoute)

    window.addEventListener('popstate', async function (e) {
        const currentState = e.state
        if (currentState) await route(currentState.title, currentState.url)
    })
})

function codeError() {
    const $codeMirror = $(`#CodeMirrorException, #CodeMirrorError`)

    if ($codeMirror.length) $codeMirror.each(function () {
        const $this = $(this)
        const line = parseInt($this.data('line')) - 1
        const message = $this.data('message')

        const editor = CodeMirror.fromTextArea($this.get(0), {
            mode: "application/x-httpd-php",
            theme: "ayu-dark",
            value: $this.val(),
            matchBrackets: true,
            indentUnit: 4,
            indentWithTabs: true,
            lineNumbers: true
        })

        editor.addLineClass(line, "text-decoration", "CodeMirror-error-line")

        $this.siblings().popover({
            trigger: 'hover',
            content: message
        })
    })
}

const route = async (title, url = "/index", usePreloader = false) => {
    const Config = CONFIG()
    const URL_BACKEND = `${Config.BASE_SERVER}/assets/menu/menu.php`

    const request = await fetch(`${URL_BACKEND}?action=checkSession`)
    const checkSession = await request.json()

    if (checkSession.status === true) {
        if (url && !["#", ""].includes(url)) {
            const $preloader = $(`.preloader`)
            const headTitle = $(`head title`)

            url = url.replace(Config.BASE_SERVER, "") || "/index"

            history.pushState({
                title: title,
                url: url
            }, title, Config.BASE_SERVER + url)

            headTitle.html(title)

            $.ajax(`${URL_BACKEND}?action=view`, {
                type: "POST",
                dataType: "HTML",
                data: { view: url },
                beforeSend: () => {
                    if (usePreloader) $preloader.removeAttr(`style`).find(`img`).removeAttr(`style`)
                },
                success: (response) => {
                    const $router = $(`[data-router]`)
                    $router.replaceWith(response)
                    codeError()
                },
                complete: () => {
                    const loadJS = $(`LOAD-SCRIPT`)
                    if (loadJS.length) {
                        JSON.parse(loadJS.text()).forEach((e) => {
                            $.getScript(e)
                        })
                        loadJS.remove()
                    }
                    if (usePreloader) setTimeout(() => {
                        $preloader.css({ height: 0 }).find(`img`).css({ display: "none" })
                    }, 1000)
                }
            })
        }
    } else window.location.href = Config.BASE_SERVER
}