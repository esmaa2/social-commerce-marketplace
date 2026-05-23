const m=[{id:"1",author:{name:"Sarah Johnson",username:"@sarah_j",avatar:"SJ"},content:"Excited to introduce my latest handmade jewelry collection. Each piece is meticulously crafted with premium materials, blending timeless elegance with modern flair. Ideal for special occasions or everyday wear—treat yourself or a loved one today!",image:"https://images.squarespace-cdn.com/content/v1/5f9586dce522ff4870b75308/1632240821141-RZJOKIR8BJOJV8MSDCAK/Fall-jewelry-collection.png",timestamp:"2h",likes:0,dislikes:0,comments:0,shares:0,isMarketplace:!0,price:"$45.00",originalPrice:"$60.00",isFollowing:!0,feedType:"following",likedBy:[]},{id:"2",author:{name:"Tech Store Pro",username:"@techstore",avatar:"TS"},content:"Discover our premium wireless headphones featuring advanced noise cancellation technology. Enjoy immersive sound quality, extended battery life, and ergonomic design for all-day comfort. Perfect for music lovers and professionals alike.",image:"https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/MQTP3?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=SUFReFd6NEVVOW50TTcxUzVyWlhHZ2tuVHYzMERCZURia3c5SzJFOTlPZ3oveDdpQVpwS0ltY2w2UW05aU90TzVtaW9peGdOaitwV1Nxb1VublZoTVE",timestamp:"4h",likes:0,dislikes:0,comments:0,shares:0,isMarketplace:!0,price:"$199.99",originalPrice:"$299.99",isFollowing:!1,feedType:"discover",likedBy:[]},{id:"3",author:{name:"Alex Chen",username:"@alexc",avatar:"AC"},content:"Captured this stunning sunset during my evening stroll. In our fast-paced world, it's moments like these that remind us to pause and appreciate nature's beauty. Wishing everyone a peaceful evening filled with simple joys.",image:"https://images.unsplash.com/photo-1624365700883-cc574778eff5?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8c3Vuc2V0JTIwYmVhY2h8ZW58MHx8MHx8fDA%3D",timestamp:"6h",likes:0,dislikes:0,comments:0,shares:0,isMarketplace:!1,isFollowing:!0,feedType:"following",visibility:"friends",likedBy:[]},{id:"4",author:{name:"Maria Rodriguez",username:"@maria_r",avatar:"MR"},content:"Thrilled to unveil my newest photography series after months of dedicated work. This collection explores themes of connection and creativity, showcasing how art can bridge diverse perspectives and foster meaningful dialogues.",image:"https://images.unsplash.com/photo-1452587925148-ce544e77e70d?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGhvdG9ncmFwaHl8ZW58MHx8MHx8fDA%3D",timestamp:"8h",likes:0,dislikes:0,comments:0,shares:0,isMarketplace:!1,isFollowing:!0,feedType:"following",likedBy:[]},{id:"5",author:{name:"Green Thumb Gardens",username:"@greenthumb",avatar:"GT"},content:"Harvest fresh, organic vegetables directly from our sustainable garden. Support local farming while enjoying nutrient-rich produce for wholesome meals. Available for weekend pickup—come taste the difference in quality and freshness.",image:"https://i0.wp.com/www.gardening4joy.com/wp-content/uploads/2021/06/organic-gardening-main-veg.jpg?resize=1080%2C700&ssl=1",timestamp:"12h",likes:0,dislikes:0,comments:0,shares:0,isMarketplace:!0,price:"$25.00",isFollowing:!1,feedType:"discover",likedBy:[]}];let s=[...m],l={},u="following";function h(){s.forEach(n=>{l[n.id]||(l[n.id]={isLiked:!1,isDisliked:!1,isFollowing:n.isFollowing||!1,isSaved:!1,likesCount:0,dislikesCount:0,commentsCount:0,sharesCount:0,showComments:!0,showAllComments:!1,editingCommentId:null,menuOpen:!1,comments:[],likedBy:[]})})}function v(){return s.filter(n=>n.feedType===u)}function p(){const n=s.filter(e=>e.feedType==="following").length,o=s.filter(e=>e.feedType==="discover").length;document.getElementById("following-count").textContent=`(${n})`,document.getElementById("discover-count").textContent=`(${o})`}function g(n=v()){const o=document.getElementById("posts-container");o.innerHTML="",n.forEach(e=>{const t=l[e.id],c=!!e.image,d=t.showAllComments||t.comments.length<=4?t.comments:t.comments.slice(-4),r=t.likedBy.length>0?`Liked by ${t.likedBy.map(i=>`<span class="liked-by-user" data-username="${i}" onclick="goToProfile('${i}')">${i}</span>`).join(", ")}`:"",a=document.createElement("div");a.className="post-card",a.innerHTML=`
            <div class="post-header">
                <div class="post-author">
                    <div class="post-avatar">${e.author.avatar}</div>
                    <div class="author-info">
                        <h3 onclick="goToProfile('${e.author.username}')">${e.author.name}${e.isMarketplace?'<span class="marketplace-badge"><svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6a2 2 0 002 2h4a2 2 0 002-2v-6M8 11h8"/></svg>Marketplace</span>':""}</h3>
                        <p class="author-meta">
                            ${e.author.username} • ${e.timestamp}
                        </p>
                    </div>
                </div>
                <div class="post-header-right">
                    <button class="follow-btn ${t.isFollowing?"following":""}" onclick="toggleFollow('${e.id}')">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${t.isFollowing?"M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z":"M12 6v6m0 0v6m0-6h6m-6 0H6"}"/>
                        </svg>
                        ${t.isFollowing?"Following":"Follow"}
                    </button>
                    <button class="menu-btn" onclick="toggleMenu('${e.id}')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                    ${t.menuOpen?`
                        <div class="menu-dropdown">
                            <div class="menu-item danger" onclick="reportUser('${e.id}')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Report User
                            </div>
                            <div class="menu-item" onclick="notInterested('${e.id}')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                </svg>
                                Not interested in content
                            </div>
                            <div class="menu-item" onclick="muteUser('${e.id}')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" clip-rule="evenodd"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>
                                </svg>
                                Mute User
                            </div>
                            <div class="menu-item danger" onclick="blockUser('${e.id}')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Block User
                            </div>
                        </div>
                    `:""}
                </div>
            </div>
            <div class="post-content">
                <div class="post-left-section">
                    ${c?`
                        <div class="post-image-container">
                            <img src="${e.image}" alt="Post content" class="post-image" onclick="openImageModal('${e.image}')">
                        </div>
                    `:""}
                    ${e.isMarketplace&&e.price?`
                        <div class="marketplace-info">
                            <div class="price-info">
                                <span class="price">${e.price}</span>
                                ${e.originalPrice?`<span class="original-price">${e.originalPrice}</span>`:""}
                            </div>
                            <button class="view-details-btn" onclick="viewDetails('${e.id}')">View Details</button>
                        </div>
                    `:""}
                    <div class="post-text-container">
                        <p class="post-text">${e.content}</p>
                    </div>
                </div>
                <div class="post-right-section">
                    <div class="comments-section">
                        <div class="comments-header">Comments (${t.commentsCount})</div>
                        <div class="comments-list">
                            ${t.comments.length>0?d.map(i=>`
                                <div class="comment">
                                    <div class="comment-avatar">${i.author.charAt(0)}</div>
                                    <div class="comment-content">
                                        <div class="comment-bubble">
                                            <p class="comment-author">${i.author}</p>
                                            ${t.editingCommentId===i.id?`
                                                <input type="text" class="edit-input" id="edit-input-${i.id}" value="${i.content}">
                                                <div class="edit-actions">
                                                    <button class="save-edit-btn" onclick="saveEdit('${e.id}', '${i.id}')">Save</button>
                                                    <button class="cancel-edit-btn" onclick="cancelEdit('${e.id}')">Cancel</button>
                                                </div>
                                            `:`
                                                <p class="comment-text">${i.content}</p>
                                            `}
                                        </div>
                                        <p class="comment-time">
                                            ${i.author==="You"&&t.editingCommentId!==i.id?`<span><button class="edit-btn" onclick="editComment('${e.id}', '${i.id}')">Edit</button> • <button class="delete-btn" onclick="deleteComment('${e.id}', '${i.id}')">Delete</button></span>`:"<span></span>"}
                                            <span>${i.timestamp==="edited"?"edited":i.timestamp}</span>
                                        </p>
                                    </div>
                                </div>
                            `).join(""):'<p class="no-comments">No comments yet</p>'}
                            ${!t.showAllComments&&t.comments.length>4?`
                                <p class="view-all-comments" onclick="showAllComments('${e.id}')">View all ${t.commentsCount} comments</p>
                            `:""}
                        </div>
                        <div class="comment-input-section">
                            <input type="text" class="comment-input" placeholder="Write a comment..." id="comment-input-${e.id}" onkeypress="handleCommentKeyPress(event, '${e.id}')">
                            <button class="send-btn" onclick="addComment('${e.id}')">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <button class="action-btn ${t.isLiked?"liked":""}" onclick="toggleLike('${e.id}')">
                    <svg class="action-icon" fill="${t.isLiked?"currentColor":"none"}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    ${t.likesCount}
                </button>
                <button class="action-btn ${t.isDisliked?"disliked":""}" onclick="toggleDislike('${e.id}')">
                    <svg class="action-icon" fill="${t.isDisliked?"currentColor":"none"}" stroke="currentColor" viewBox="0 0 24 24" transform="rotate(180)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    ${t.dislikesCount}
                </button>
                <button class="action-btn" onclick="focusCommentInput('${e.id}')">
                    <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    ${t.commentsCount}
                </button>
                <button class="action-btn" onclick="sharePost('${e.id}')">
                    <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    ${t.sharesCount}
                </button>
                <button class="action-btn save-btn ${t.isSaved?"saved":""}" onclick="toggleSave('${e.id}')">
                    <svg class="action-icon" fill="${t.isSaved?"currentColor":"none"}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </button>
            </div>
            ${r?`<p class="liked-by">${r}</p>`:""}
        `,o.appendChild(a)})}document.addEventListener("DOMContentLoaded",()=>{h(),p(),g()});
