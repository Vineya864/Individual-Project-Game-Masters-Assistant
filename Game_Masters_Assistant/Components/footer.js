class Footer extends HTMLElement {
  constructor() {
    super();
  }
  
  connectedCallback() {
    this.innerHTML = `
	
	<footer id="page-footer"> 190063731@aston.ac.uk <br/>
	 <br/>
	Developed as part of my final year project,<br/> The Game masters assistant is created for use by those who play role playing games </br> the system has been created to be used with multiple gaming systems  <br/> </footer>
	
	
	
	`;
  }
}



customElements.define('footer-component', Footer);