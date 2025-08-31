<template id="ui-modal">
  <div class="modal-backdrop" data-modal-backdrop>
    <div class="modal" role="dialog" aria-modal="true" tabindex="-1">
      <button class="modal-close" type="button" aria-label="Закрыть окно" data-modal-close>✕</button>
      <header class="modal-header" data-section="header" hidden>
        <h2 class="modal-title" id="ui-modal-title" data-field="title"></h2>
      </header>
      <div class="modal-body">
        <section class="modal-section" data-section="text" hidden>
          <div class="modal-text" data-field="text"></div>
        </section>
        <section class="modal-section" data-section="photo" hidden>
          <figure class="modal-figure">
            <img data-field="imgSrc" data-field-attr="src" alt="" data-field-alt="imgAlt" />
            <figcaption class="modal-caption" data-field="caption"></figcaption>
          </figure>
        </section>
        <section class="modal-section" data-section="video" hidden>
          <div class="video-aspect">
            <iframe
              title=""
              loading="lazy"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
              data-field="videoSrc"
              data-field-attr="src"></iframe>
          </div>
          <div class="modal-video-text" data-field="videoText"></div>
        </section>
        <section class="modal-section" data-section="html" hidden>
          <div class="modal-html" data-field-html="html"></div>
        </section>
      </div>
    </div>
  </div>
</template>