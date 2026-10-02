/**
 * Backend-free contact form (browser script, shared by both themes).
 *
 * Markup contract — each theme renders its own styled form with:
 *   <form data-contact-form data-email="you@x.com" data-endpoint="">   (endpoint optional)
 *     inputs named: name, email, phone, subject, message, website (honeypot)
 *     [data-contact-submit]            submit button
 *       [data-state="idle"] / [data-state="sending"]   button labels
 *   <… data-contact-success hidden>    success panel (sibling, inside the same [data-contact] wrapper)
 *       [data-success-text="mailto"] / [data-success-text="endpoint"]
 *       [data-contact-mailto]          optional link, gets the pre-filled mailto: href
 *       [data-contact-reset]           "send another" button
 *
 * Without an endpoint, submitting opens the visitor's email app with the
 * message pre-filled (mailto:). With an endpoint (Formspree etc. — see
 * src/config/site.js), it POSTs there and falls back to mailto on failure.
 */

function buildMailto(to, data) {
    const subject = data.subject || `Portfolio enquiry from ${data.name}`;
    const lines = [data.message, '', '—', data.name, data.email];
    if (data.phone) lines.push(data.phone);
    return `mailto:${to}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(lines.join('\n'))}`;
}

const ENDPOINT_TIMEOUT_MS = 8000;

async function postToEndpoint(endpoint, form) {
    const response = await fetch(endpoint, {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json' },
        signal: AbortSignal.timeout(ENDPOINT_TIMEOUT_MS),
    });
    if (!response.ok) throw new Error(`Form endpoint responded ${response.status}`);
}

function setSending(form, sending) {
    const button = form.querySelector('[data-contact-submit]');
    if (!button) return;
    button.disabled = sending;
    button.querySelectorAll('[data-state]').forEach((el) => {
        el.hidden = el.dataset.state !== (sending ? 'sending' : 'idle');
    });
}

function showSuccess(wrapper, form, mode, mailto = null) {
    const success = wrapper.querySelector('[data-contact-success]');
    if (!success) return;
    // A real link too, in case the browser didn't open the email app by itself.
    if (mailto) success.querySelectorAll('[data-contact-mailto]').forEach((a) => (a.href = mailto));
    success.querySelectorAll('[data-success-text]').forEach((el) => {
        el.hidden = el.dataset.successText !== mode;
    });
    form.hidden = true;
    success.hidden = false;
}

function bind(form) {
    const wrapper = form.closest('[data-contact]') ?? form.parentElement;
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!form.reportValidity()) return;

        const to = form.dataset.email;
        const endpoint = form.dataset.endpoint || '';

        const data = Object.fromEntries(
            [...new FormData(form).entries()].map(([k, v]) => [k, String(v).trim()]),
        );

        // Honeypot filled → silently "succeed" for bots.
        if (data.website) {
            showSuccess(wrapper, form, endpoint ? 'endpoint' : 'mailto');
            return;
        }

        if (endpoint) {
            setSending(form, true);
            try {
                await postToEndpoint(endpoint, form);
                form.reset();
                showSuccess(wrapper, form, 'endpoint');
                return;
            } catch {
                // Service unavailable — fall through to the email-app method.
            } finally {
                setSending(form, false);
            }
        }

        const mailto = buildMailto(to, data);
        window.location.href = mailto;
        showSuccess(wrapper, form, 'mailto', mailto);
    });

    wrapper.querySelector('[data-contact-reset]')?.addEventListener('click', () => {
        wrapper.querySelector('[data-contact-success]').hidden = true;
        form.hidden = false;
    });
}

export function initContactForms() {
    document.querySelectorAll('form[data-contact-form]').forEach(bind);
}
