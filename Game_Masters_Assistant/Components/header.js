class Header extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = `
     <header id="page-header"> 
	<section id="nav-bar">
		<ul>
        <li><a href="index.php">Game Masters Assistant </a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="help_page.php">Help</a></li>
        <li><a href="my_account.php">My Account</a></li>
		<li> <section id="log-in"> 
			<a href="login.php">
			<button>Log In</button>
			</a>
			</section>
		</li>
      </div>
	  </div>
	</section>
	
	</header>
    `;
  }
}

customElements.define('header-component', Header);
