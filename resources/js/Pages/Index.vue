<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Clixode</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'bucket.index'}">Buckets</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'bucket-image.edit', params: {id: '123'}}">Bucket image</router-link>
                    </li>
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" href="#">Pricing</a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item dropdown">-->
<!--                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">-->
<!--                                                Dropdown link-->
<!--                                            </a>-->
<!--                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->
<!--                                                <li><a class="dropdown-item" href="#">Action</a></li>-->
<!--                                                <li><a class="dropdown-item" href="#">Another action</a></li>-->
<!--                                                <li><a class="dropdown-item" href="#">Something else here</a></li>-->
<!--                                            </ul>-->
<!--                                    </li>-->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="body">
            <div class="content mt-4">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Index'
};
</script>
