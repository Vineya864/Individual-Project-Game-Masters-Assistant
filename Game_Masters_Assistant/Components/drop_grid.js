class drop_grid extends HTMLElement {
  constructor() {
    super();
  }
  
connectedCallback() {
  this.innerHTML = `
  <div id = "drop_grid">
	
	<div class="drop_location" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
  </div>
	
`;
  }
}


customElements.define('drop_grid-component', Drop_grid);